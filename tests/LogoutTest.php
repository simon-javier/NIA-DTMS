<?php
use PHPUnit\Framework\TestCase;

class LogoutTest extends TestCase {

    public function testLogoutFunction() {
        // Start session to simulate real condition
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['user'] = 'admin';  // simulate logged in

        require_once __DIR__ . '/../logout.php';

        $result = logout();

        $this->assertTrue($result);
        $this->assertEmpty($_SESSION);
    }
}
