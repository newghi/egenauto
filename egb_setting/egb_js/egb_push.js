/**
 * egb_push.js
 * 
 * 실시간 푸시 알림 처리를 위한 유틸리티 모듈
 * 
 * 주요 기능:
 * - Pusher/Ably 웹소켓 연결 관리
 * - 채널 구독 및 이벤트 바인딩
 * - 메시지 수신 및 핸들러 처리
 * - 연결 해제 및 정리 작업
 * - bfcache 호환성을 위한 자동 연결 해제
 * 
 * 사용 예시:
 * // Pusher 초기화
 * const pusher = EGB.push.initPusher(key, cluster, channel, events, handlers);
 * 
 * // Ably 초기화  
 * const ably = EGB.push.initAbly(key, channel, events, handlers);
 * 
 * // 연결 해제
 * pusher.cleanup();
 * ably.cleanup();
 */

; (function (global) {
    const EGB = global.EGB = global.EGB || {};

    function bindPushEvents(channelObj, subscribeFn, service, events, handlers) {
        const boundHandlers = new Map();

        events.forEach(event => {
            const handler = handlers[event] || (() => { });
            const boundHandler = payload => {
                let data;
                try { data = typeof payload == 'string' ? JSON.parse(payload) : payload; }
                catch { data = payload; }
                console.log(`[${service} 수신] ${event}`, data);
                handler(data);
            };

            boundHandlers.set(event, boundHandler);
            subscribeFn(channelObj, event, boundHandler);
        });

        return boundHandlers;
    }

    function initPusher(key, cluster, channelName, events, handlers) {
        const p = new Pusher(key, { cluster, encrypted: true, disableStats: true });
        const ch = p.subscribe(channelName);
        const boundHandlers = bindPushEvents(ch, (c, e, h) => c.bind(e, h), 'Pusher', events, handlers);

        let cleaned = false;   // cleanup 한 번만 실행되도록 플래그

        return {
            connection: p,
            channel: ch,
            handlers: boundHandlers,
            cleanup: () => {
                if (cleaned) {
                    console.log('[EGB Push] Pusher cleanup already done');
                    return;
                }
                cleaned = true;

                // Pusher 내부 상태 확인 (initialized, connecting, connected, unavailable, failed, disconnected)
                const state = p.connection.state;
                if (state !== 'connected') {
                    console.log('[EGB Push] Pusher cleanup skipped (state:', state, ')');
                    return;
                }

                // 실제 해제 로직
                ch.unbind_all();
                p.unsubscribe(channelName);
                p.disconnect();
            }
        };
    }

    function initAbly(key, channelName, events, handlers) {
        const a = new Ably.Realtime(key);
        const ch = a.channels.get(channelName);
        const boundHandlers = bindPushEvents(ch, (c, e, h) => c.subscribe(e, m => h(m.data)), 'Ably', events, handlers);

        let cleaned = false;   // cleanup 한 번만 실행되도록 플래그

        return {
            connection: a,
            channel: ch,
            handlers: boundHandlers,
            cleanup: () => {
                if (cleaned) {
                    console.log('[EGB Push] Ably cleanup already done');
                    return;
                }
                cleaned = true;

                // Ably 내부 상태 확인 (initialized, connecting, connected, disconnected, suspended, failed, closed)
                const state = a.connection.state;
                if (state !== 'connected') {
                    console.log('[EGB Push] Ably cleanup skipped (state:', state, ')');
                    return;
                }

                // 실제 해제 로직
                boundHandlers.forEach((handler, event) => ch.unsubscribe(event, handler));
                boundHandlers.clear();
                ch.detach();
                a.close();
            }
        };
    }

    let currentConnections = null;
    let pageHideHandler = null;
    let freezeHandler = null;
    let pageShowHandler = null;
    
    // 마지막 init 인자 저장용
    let lastConfig = null;
    
    // pagehide/freeze에서만 cleanup 한 번 실행되도록 플래그
    let cleanedUp = false;

    // bfcache 호환성을 위한 이벤트 핸들러
    function handlePageHide() {
        if (!cleanedUp && currentConnections) {
            cleanedUp = true;
            console.log('[EGB Push] 페이지 숨김/동결 - WebSocket 연결 해제');
            currentConnections.pusher.cleanup();
            currentConnections.ably.cleanup();
            currentConnections = null;
        }
    }

    function handleFreeze() {
        handlePageHide(); // 동일한 로직 사용
    }

    // bfcache 복원 시 자동 재연결
    function handlePageShow(event) {
        if (event.persisted && lastConfig) {
            console.log('[EGB Push] bfcache 복원 – WebSocket 재연결');
            cleanedUp = false; // 재연결 시 플래그 리셋
            EGB.push.init(
                lastConfig.userUniqId,
                lastConfig.events,
                lastConfig.handlers
            );
        }
    }

    // 페이지 이벤트 리스너 등록
    function setupPageEventListeners() {
        if (!pageHideHandler) {
            pageHideHandler = handlePageHide;
            window.addEventListener('pagehide', pageHideHandler, { passive: true });
        }
        
        if (!freezeHandler) {
            freezeHandler = handleFreeze;
            document.addEventListener('freeze', freezeHandler, { passive: true });
        }

        if (!pageShowHandler) {
            pageShowHandler = handlePageShow;
            window.addEventListener('pageshow', pageShowHandler, { passive: true });
        }
    }

    // 페이지 이벤트 리스너 제거
    function removePageEventListeners() {
        if (pageHideHandler) {
            window.removeEventListener('pagehide', pageHideHandler);
            pageHideHandler = null;
        }
        
        if (freezeHandler) {
            document.removeEventListener('freeze', freezeHandler);
            freezeHandler = null;
        }

        if (pageShowHandler) {
            window.removeEventListener('pageshow', pageShowHandler);
            pageShowHandler = null;
        }
    }

    EGB.push = {
        init(userUniqId, events, handlers) {
            if (!userUniqId) return;

            // 마지막 설정 저장
            lastConfig = { userUniqId, events, handlers };
            
            // 재연결 시 플래그 리셋
            cleanedUp = false;

            // 기존 연결 정리
            if (currentConnections) {
                currentConnections.pusher.cleanup();
                currentConnections.ably.cleanup();
            }

            const channel = 'public-user-' + userUniqId;
            currentConnections = {
                pusher: initPusher('278be27a1f4c3bac0d09', 'ap3', channel, events, handlers),
                ably: initAbly('SsULZg.gSNlVg:obaU7WUU5IKZSJOwyYWjbE1uf6Q2mFbQNmIIrfAKloE', channel, events, handlers)
            };

            // bfcache 호환성을 위한 이벤트 리스너 설정
            setupPageEventListeners();
        },

        // 수동 연결 해제 함수
        disconnect() {
            if (currentConnections) {
                console.log('[EGB Push] 수동 연결 해제');
                
                // cleanup 함수 내부에서 cleaned 플래그와 연결 상태를 모두 확인
                currentConnections.pusher.cleanup();
                currentConnections.ably.cleanup();
                
                currentConnections = null;
            }
        },

        // 페이지 이벤트 리스너 정리
        cleanup() {
            removePageEventListeners();
            this.disconnect();
            lastConfig = null;
            cleanedUp = false;
        }
    };

    // 안전한 초기화 함수 추가
    EGB.push.initSafe = function(userUniqId, events, handlers) {
        if (window.EGB?.push?.init) {
            EGB.push.init(userUniqId, events, handlers);
        }
    };

    // beforeunload 이벤트 리스너 제거 (bfcache 호환성을 위해)
    // window.addEventListener('beforeunload', () => {
    //     EGB.push?.cleanup();
    // });
})(window);
