<?php
class MySessionHandler extends SessionHandler {
    private $db;

    public function open(string $savePath, string $sessionName): bool {
        $this->db = new PDO("mysql:host=localhost;dbname=servicediscovery", "root", "");
        return true;
    }

    public function read($sessionId): string {
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE id = ?");
        $stmt->execute([$sessionId]);
        return $stmt->fetchColumn() ?: '';
    }

    public function write($sessionId, $data): bool {
        $stmt = $this->db->prepare("REPLACE INTO sessions (id, data) VALUES (?, ?)");
        return $stmt->execute([$sessionId, $data]);
    }
    
    public function destroy($sessionId): bool {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = ?");
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
