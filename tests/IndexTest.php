<?php

use PHPUnit\Framework\TestCase;

final class AppTest extends TestCase
{
    public function testIndexFileExists(): void
    {
        $this->assertFileExists("index.php");
    }

    public function testLoginFileExists(): void
    {
        $this->assertFileExists("login.php");
    }
}
