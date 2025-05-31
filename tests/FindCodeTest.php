<?php
use PHPUnit\Framework\TestCase;

class FindCodeTest extends TestCase {
    public function testFindCodeInvalid() {
        $_POST['action'] = 'find_code';
        $_POST['code'] = 'INVALIDCODE123';

        ob_start();
        include __DIR__ . '/../controller/upload-docu-controller.php'; // adjust path
        $output = ob_get_clean();

        $this->assertStringContainsString('"status":"failed"', $output);
    }
}
