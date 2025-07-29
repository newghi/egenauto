<?php
// PHP 7.4 호환 DB 유틸 클래스 및 함수

class DB {
    private static ?PDO $pdo = null;

    // 1) PDO 반환 (싱글톤)
    public static function pdo(): ?PDO {
        if (self::$pdo === null) {
            if (!defined('DB_HOST') || !defined('DB_NAME') || !defined('DB_USER') || !defined('DB_PASSWORD')) {
                return null;
            }

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                DB_HOST,
                DB_NAME
            );

            self::$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => false, // 영구 연결 비활성화
            ]);
        }
        return self::$pdo;
    }

    // 2) 커넥션 해제
    public static function close(): void {
        self::$pdo = null;
    }

    // 3) 대용량 조회용 Generator (stream)
    public static function stream(string $sql, array $params = []): ?\Generator {
        $pdo = self::pdo();
        if ($pdo === null) return null;

        $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        try {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                yield $row;
            }
        } finally {
            $stmt->closeCursor();
            $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        }
    }
}

/**
 * SQL 쿼리에서 테이블명 추출 (개선된 버전)
 */
function extract_table_name($sql) {
    $sql = trim($sql);
    
    // SELECT 쿼리에서 테이블명 추출 (JOIN, 백틱 지원)
    if (preg_match('/^SELECT\s+.+?\s+FROM\s+[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $matches)) {
        return $matches[1];
    }
    
    // INSERT 쿼리에서 테이블명 추출 (백틱 지원)
    if (preg_match('/^INSERT\s+(?:INTO\s+)?[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $matches)) {
        return $matches[1];
    }
    
    // UPDATE 쿼리에서 테이블명 추출 (백틱 지원)
    if (preg_match('/^UPDATE\s+[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $matches)) {
        return $matches[1];
    }
    
    // DELETE 쿼리에서 테이블명 추출 (백틱 지원)
    if (preg_match('/^DELETE\s+(?:FROM\s+)?[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $matches)) {
        return $matches[1];
    }
    
    return null;
}

/**
 * 1) 모든 참조 테이블 추출 (JOIN, 서브쿼리 등 복합 쿼리 지원)
 */
function extract_table_names(string $sql): array {
    $tables = [];
    $sql = trim($sql);
    
    // FROM 절에서 테이블 추출
    if (preg_match_all('/\bFROM\s+[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $m)) {
        $tables = array_merge($tables, $m[1]);
    }
    
    // JOIN 절에서 테이블 추출
    if (preg_match_all('/\bJOIN\s+[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $m)) {
        $tables = array_merge($tables, $m[1]);
    }
    
    // UPDATE 쿼리에서 테이블 추출
    if (preg_match_all('/\bUPDATE\s+[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $m)) {
        $tables = array_merge($tables, $m[1]);
    }
    
    // INSERT 쿼리에서 테이블 추출
    if (preg_match_all('/\bINSERT\s+(?:INTO\s+)?[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $m)) {
        $tables = array_merge($tables, $m[1]);
    }
    
    // DELETE 쿼리에서 테이블 추출
    if (preg_match_all('/\bDELETE\s+(?:FROM\s+)?[`"]?([a-zA-Z0-9_]+)[`"]?/i', $sql, $m)) {
        $tables = array_merge($tables, $m[1]);
    }
    
    return array_unique($tables);
}

/**
 * 캐시 제외 대상 테이블인지 확인
 */
function is_cache_excluded_table($table_name) {
    if (empty($table_name)) return false;
    
    // 캐시 제외할 테이블 패턴들
    $exclude_patterns = [
        // 로그 관련 테이블 (자주 INSERT되므로)
        '/^.*_log$/i',           // _log로 끝나는 모든 테이블

        '/^egb_board_.*$/i', // 게시판 테이블
        '/^egb_comment_.*$/i', // 댓글 테이블       
        
        // 특정 테이블명들
        '/^egb_log$/i',     // 좋아요 로그


    ];
    
    // 제외 패턴에 매칭되는지 확인
    foreach ($exclude_patterns as $pattern) {
        if (preg_match($pattern, $table_name)) {
            return true;
        }
    }
    
    return false;
}

/**
 * 3) 특정 테이블을 포함한 캐시만 무효화
 */
function egb_cache_invalidate_table(string $table_name): void {
    if (!defined('EGB_CACHE_DIR')) {
        return;
    }
    
    $cache_files = glob(EGB_CACHE_DIR . '*.cache');
    $invalidated_count = 0;
    
    foreach ($cache_files as $file) {
        $raw = @file_get_contents($file);
        if ($raw === false) {
            continue;
        }
        
        $entry = @unserialize($raw);
        if (!is_array($entry) || empty($entry['tables'])) {
            continue;
        }
        
        // 해당 테이블을 참조하는 캐시인지 확인
        if (in_array($table_name, $entry['tables'], true)) {
            if (@unlink($file)) {
                $invalidated_count++;
                egb_error_log("[캐시 무효화] 테이블: {$table_name} -> " . basename($file));
            }
        }
    }
    
    if ($invalidated_count > 0) {
        egb_error_log("[캐시 무효화 완료] 테이블: {$table_name} - {$invalidated_count}개 캐시 삭제");
    }
}

// 4) 다중 쿼리 실행 + 트랜잭션 처리 + 캐시 기능
function egb_sql(...$queries) {
    $pdo = DB::pdo();
    if ($pdo === null) {
        return false;
    }

    $results = [];
    $modified_tables = []; // 수정된 테이블 목록
    $needsTransaction = false;
    foreach ($queries as $q) {
        if (!isset($q['fetch']) || $q['fetch'] !== 3) {
            $needsTransaction = true;
            break;
        }
    }

    try {
        if ($needsTransaction) {
            $pdo->beginTransaction();
        }

        foreach ($queries as $q) {
            // 필수 필드 확인
            if (!isset($q['sql'], $q['params'], $q['fetch'])) {
                throw new InvalidArgumentException('쿼리 데이터 불완전');
            }

            $sql = trim($q['sql']);
            $is_modifying = stripos($sql, 'INSERT') === 0 || stripos($sql, 'UPDATE') === 0 || stripos($sql, 'DELETE') === 0;
            
            // --- 수정 쿼리 실행 전 해당 테이블 관련 캐시 삭제 ---
            if ($is_modifying) {
                $tables = extract_table_names($sql);
                foreach ($tables as $table_name) {
                    $modified_tables[] = $table_name;
                }
                egb_error_log('[DML 쿼리 실행] 테이블: ' . implode(', ', $tables) . ' - SQL: ' . substr($q['sql'], 0, 50) . '...');
            }

            // --- 캐시 적용 여부 판단 (fetchAll(0), fetch(1) 만) ---
            $isRead = in_array($q['fetch'], [0,1], true);
            if ($isRead) {
                // 내부에서 키 생성 (SQL + params 조합 해시)
                $cacheKey = 'egb_sql_'. sha1($q['sql'] . '|' . serialize($q['params']));
                $cached = egb_cache_load($cacheKey);
                if ($cached !== false) {
                    // 캐시 히트 - DB 쿼리 스킵
                    egb_error_log('[캐시 히트] 테이블: ' . implode(', ', $cached['tables']) . ' - SQL: ' . substr($q['sql'], 0, 50) . '...');
                    $results[] = $cached['data'];
                    continue;  // 캐시 히트하면 쿼리 실행 스킵
                }
                // 캐시 미스 또는 실패 - DB 쿼리 실행
                egb_error_log('[캐시 미스] SQL: ' . substr($q['sql'], 0, 50) . '...');
                $doCache = true;
            } else {
                $doCache = false;
            }

            // 쿼리 실행
            $stmt = $pdo->prepare($q['sql']);
            foreach ($q['params'] as $key => $val) {
                $stmt->bindValue($key, $val);
            }
            $stmt->execute();

            // 결과 얻기
            switch ($q['fetch']) {
                case 0:
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case 1:
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    break;
                case 2:
                case 3:
                    $res = $stmt->rowCount();
                    break;
                default:
                    throw new InvalidArgumentException('알 수 없는 fetch 모드: '.$q['fetch']);
            }

            // --- 캐시 저장 (TTL 메타데이터 포함) ---
            if ($doCache) {
                // 모든 참조 테이블 추출
                $tables = extract_table_names($q['sql']);
                
                // 캐시 제외 대상 테이블인지 확인 (첫 번째 테이블만 체크)
                $first_table = $tables[0] ?? '';
                if (is_cache_excluded_table($first_table)) {
                    egb_error_log('[캐시 저장 제외] 테이블: ' . $first_table);
                } else {
                    // TTL 메타데이터를 포함한 캐시 데이터 구조 (tables 필드 추가)
                    $cache_data = [
                        'expires_at' => time() + (defined('EGB_CACHE_TTL') ? EGB_CACHE_TTL : 3600),
                        'tables' => $tables,
                        'sql' => $q['sql'],
                        'params' => $q['params'],
                        'fetch' => $q['fetch'],
                        'data' => $res
                    ];
                    
                    $cache_saved = egb_cache_save($cacheKey, $cache_data);
                    if ($cache_saved) {
                        egb_error_log('[캐시 저장] 테이블: ' . implode(', ', $tables) . ' - SQL: ' . substr($q['sql'], 0, 50) . '...');
                    } else {
                        egb_error_log('[캐시 저장 실패] 테이블: ' . implode(', ', $tables) . ' - SQL: ' . substr($q['sql'], 0, 50) . '...');
                    }
                }
            }

            $results[] = $res;
        }

        // --- DML 처리 후 해당 테이블 관련 캐시 무효화 ---
        if (!empty($modified_tables)) {
            $unique_tables = array_unique($modified_tables);
            foreach ($unique_tables as $table_name) {
                egb_cache_invalidate_table($table_name);
            }
        }

        if ($needsTransaction) {
            $pdo->commit();
        }

        return $results;

    } catch (\Exception $e) {
        if ($needsTransaction && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        egb_error_log('[DB 오류] '.$e->getMessage());
        return false;
    }
}

/**
 * 캐시 사용 현황 확인 (개선된 버전)
 */
function egb_cache_status() {
    $cache_files = glob(EGB_CACHE_DIR . '*.cache');
    $sql_cache_count = 0;
    $expired_cache_count = 0;
    $total_cache_count = count($cache_files);
    $current_time = time();
    
    foreach ($cache_files as $file) {
        $cache_key = file_get_contents($file);
        if ($cache_key !== false) {
            $unserialized = unserialize($cache_key);
            if ($unserialized !== false && is_array($unserialized)) {
                // SQL 캐시인지 확인 (메타데이터 포함 여부)
                if (isset($unserialized['expires_at']) && isset($unserialized['tables'])) {
                    $sql_cache_count++;
                    
                    // 만료된 캐시 확인
                    if ($unserialized['expires_at'] < $current_time) {
                        $expired_cache_count++;
                    }
                }
            }
        }
    }
    
    return [
        'total_cache_files' => $total_cache_count,
        'sql_cache_files' => $sql_cache_count,
        'expired_cache_files' => $expired_cache_count,
        'cache_dir' => EGB_CACHE_DIR,
        'cache_ttl' => defined('EGB_CACHE_TTL') ? EGB_CACHE_TTL : 3600
    ];
}

/**
 * 만료된 캐시 파일 정리
 */
function cleanup_expired_cache() {
    $cache_files = glob(EGB_CACHE_DIR . '*.cache');
    $deleted_count = 0;
    $current_time = time();
    
    foreach ($cache_files as $file) {
        $cache_key = file_get_contents($file);
        if ($cache_key !== false) {
            $unserialized = unserialize($cache_key);
            if ($unserialized !== false && is_array($unserialized)) {
                // TTL 메타데이터가 있는 캐시만 확인
                if (isset($unserialized['expires_at'])) {
                    if ($unserialized['expires_at'] < $current_time) {
                        try {
                            if (unlink($file)) {
                                $deleted_count++;
                            }
                        } catch (Exception $e) {
                            egb_error_log('[캐시 정리 오류] 파일: ' . $file . ' - ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    }
    
    if ($deleted_count > 0) {
        egb_error_log('[캐시 정리] 만료된 캐시 ' . $deleted_count . '개 삭제');
    }
    
    return $deleted_count;
}

?>