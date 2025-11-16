<?php

use PHPUnit\Framework\TestCase;

if (!defined('DB_HOST')) {
    require_once __DIR__ . '/../config.php';
}

class DatabaseTest extends TestCase
{

    public function testDatabaseConnection()
    {
        $db = Database::getInstance();

        $this->assertInstanceOf(Database::class, $db);
    }

    public function testGetConnection()
    {
        $db = Database::getInstance();
        $connection = $db->getConnection();

        $this->assertInstanceOf(PDO::class, $connection);
    }

    public function testSingletonPattern()
    {
        $db1 = Database::getInstance();
        $db2 = Database::getInstance();

        $this->assertSame($db1, $db2);
    }

    public function testDatabaseQuery()
    {
        $db = Database::getInstance();
        $connection = $db->getConnection();

        $stmt = $connection->query("SELECT 1 as test");
        $result = $stmt->fetch();

        $this->assertEquals(1, $result['test']);
    }

    public function testDatabaseTablesExist()
    {
        $db = Database::getInstance();
        $connection = $db->getConnection();

        $tables = ['users', 'events', 'reservations', 'gallery_photos'];

        foreach ($tables as $table) {
            $stmt = $connection->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_name = '$table'");
            $count = $stmt->fetchColumn();

            $this->assertGreaterThan(0, $count, "Table $table should exist");
        }
    }
}
