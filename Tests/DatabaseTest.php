<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';

class DatabaseTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function testDatabaseConnection()
    {
        $this->assertInstanceOf(PDO::class, $this->db);
    }

    public function testDatabaseQuery()
    {
        $stmt = $this->db->query("SELECT 1 as test");
        $result = $stmt->fetch();

        $this->assertEquals(1, $result['test']);
    }

    public function testDatabasePreparedStatement()
    {
        $stmt = $this->db->prepare("SELECT ? as value");
        $stmt->execute([42]);
        $result = $stmt->fetch();

        $this->assertEquals(42, $result['value']);
    }

    public function testDatabaseTransaction()
    {
        $this->db->beginTransaction();
        $this->assertTrue($this->db->inTransaction());
        $this->db->rollBack();
        $this->assertFalse($this->db->inTransaction());
    }
}
