<?php
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase {
    public function testDatabaseConnection() {
        require __DIR__ . '/../connection.php';
        $this->assertInstanceOf(PDO::class, $pdo);
    }
}
