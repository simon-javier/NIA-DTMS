<?php
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase {
    public function testPasswordHashAndVerify() {
        $plain = "sysadmin";

        // Generate a hash just like your hash.php
        $hashed_password = password_hash($plain, PASSWORD_DEFAULT);

        // Assert the hashed password is not the plain text
        $this->assertNotEquals($plain, $hashed_password);

        // Assert the hash verifies correctly
        $this->assertTrue(password_verify($plain, $hashed_password));
    }
}
