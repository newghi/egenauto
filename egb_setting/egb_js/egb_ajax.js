// ajax 전역 설정
/**
 * egb_ajax.js
 * 
 * AJAX 요청 처리를 위한 유틸리티 모듈
 * 
 * 주요 기능:
 * - axios, fetch, XMLHttpRequest 자동 폴백 지원
 * - CSRF 토큰 자동 처리 
 * - GET/POST 메소드 지원
 * - JSON/FormData/x-www-form-urlencoded 데이터 처리
 * - 성공/실패/에러/완료 콜백 지원
 * - withCredentials 자동 설정
 * 
 */
; (function (global) {
    const EGB = global.EGB = global.EGB || {};

    EGB.ajax = {
        request(options) {
            const baseUrl = window.location.origin + '/?post=';
            const method = options.method || 'POST';
            let headers = options.headers || { 'X-CSRF-Token': egbCsrfToken };
            const dataType = options.dataType || 'json';

            let url = options.url.startsWith('http') ? options.url : baseUrl + options.url;

            let requestOptions = {
                method: method,
                headers: headers,
                withCredentials: true,
            };

            if (method === 'GET' && options.data) {
                const params = new URLSearchParams(options.data).toString();
                url += '?' + params;
            } else if (method !== 'GET' && options.data) {
                if (options.data instanceof FormData) {
                    requestOptions.data = options.data;
                    requestOptions.body = options.data;
                    delete headers['Content-Type'];
                } else if (typeof options.data === 'object') {
                    requestOptions.data = JSON.stringify(options.data);
                    requestOptions.body = JSON.stringify(options.data);
                    headers['Content-Type'] = 'application/json';
                } else {
                    requestOptions.data = options.data;
                    requestOptions.body = options.data;
                    headers['Content-Type'] = headers['Content-Type'] || 'application/x-www-form-urlencoded';
                }
            }

            const handleResponse = (response) => {
                if (!response.ok) {
                    throw new Error('네트워크 응답에 문제가 있습니다.');
                }
                return dataType === 'json' ? response.json() : response.text();
            };

            const axiosData = () => {
                axios({
                    url: url,
                    method: requestOptions.method,
                    headers: requestOptions.headers,
                    data: requestOptions.data,
                    withCredentials: true
                })
                    .then(response => {
                        const data = response.data;
                        if (data.success) {
                            if (options.success) options.success(data);
                        } else {
                            data.errorCode = data.errorCode || 0;
                            if (options.failure) options.failure(data);
                        }
                    })
                    .catch(error => {
                        if (options.error) options.error({ success: false, errorCode: error.message });
                    })
                    .finally(() => {
                        if (options.complete) options.complete();
                    });
            };

            const fetchData = () => {
                fetch(url, {
                    method: requestOptions.method,
                    headers: requestOptions.headers,
                    body: requestOptions.body,
                    credentials: 'include'
                })
                    .then(handleResponse)
                    .then(data => {
                        if (data.success) {
                            if (options.success) options.success(data);
                        } else {
                            data.errorCode = data.errorCode || 0;
                            if (options.failure) options.failure(data);
                        }
                    })
                    .catch(error => {
                        if (options.error) options.error({ success: false, errorCode: error.message });
                    })
                    .finally(() => {
                        if (options.complete) options.complete();
                    });
            };

            const xhrData = () => {
                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                if (!(options.data instanceof FormData)) {
                    for (let key in headers) {
                        xhr.setRequestHeader(key, headers[key]);
                    }
                } else {
                    if (headers['X-CSRF-Token']) {
                        xhr.setRequestHeader('X-CSRF-Token', headers['X-CSRF-Token']);
                    }
                }

                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const response = dataType === 'json' ? JSON.parse(xhr.responseText) : xhr.responseText;
                        if (response.success) {
                            if (options.success) options.success(response);
                        } else {
                            response.errorCode = response.errorCode || 0;
                            if (options.failure) options.failure(response);
                        }
                    } else {
                        if (options.error) options.error({ success: false, errorCode: xhr.statusText });
                    }
                };

                xhr.onerror = function () {
                    if (options.error) options.error({ success: false, errorCode: xhr.status + ' ' + xhr.statusText });
                };

                xhr.onloadend = function () {
                    if (options.complete) options.complete();
                    xhr.onload = null;
                    xhr.onerror = null;
                    xhr.onloadend = null;
                };

                xhr.send(method === 'GET' ? null : requestOptions.body);
            };

            if (window.axios) {
                axiosData();
                console.log('axios 사용됨');
            } else if (window.fetch) {
                fetchData();
                console.log('fetch 사용됨');
            } else {
                xhrData();
                console.log('xhr 사용됨');
            }
        }
    };
})(window);