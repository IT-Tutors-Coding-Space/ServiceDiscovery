<?php
class MySessionHandler extends SessionHandler {
    private $db;

    public function open(string $savePath, string $sessionName): bool {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=service_connect", "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("SessionHandler DB Connection Error: " . $e->getMessage());
            return false;
        }
    }

    public function read($sessionId): string {
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE session_id = ?");
        $stmt->execute([$sessionId]);
        return $stmt->fetchColumn() ?: '';
    }

    public function write($sessionId, $data): bool {
        $stmt = $this->db->prepare("INSERT INTO sessions (session_id, data, last_activity) 
                                    VALUES (?, ?, NOW()) 
                                    ON DUPLICATE KEY UPDATE data = ?, last_activity = NOW()");
        return $stmt->execute([$sessionId, $data, $data]);
    }

    public function destroy($sessionId): bool {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE session_id = ?");
        return $stmt->execute([$sessionId]);
    }

    public function gc($maxlifetime): int {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE last_access < NOW() - INTERVAL $maxlifetime SECOND");
        $stmt->execute();
        return $stmt->rowCount();
    }
}

$handler = new MySessionHandler();
session_set_save_handler($handler, true);
session_start();
?>
