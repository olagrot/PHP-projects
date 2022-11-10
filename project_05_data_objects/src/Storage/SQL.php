<?php

namespace Storage;

use Concept\Distinguishable;
use Config\Directory;
use PDO;

abstract class SQL implements Storage
{
    use SerializationHelpers;
    private PDO $pdo;
    private string $table_name;

    public function __construct()
    {
        if (static::class=="Storage\MySQLStorage") {
            $this->pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=test", "test", "test123");

            $this->table_name="test.objects";
        }

        if (static::class=="Storage\SQLiteStorage") {
            $this->pdo = new PDO("sqlite:".Directory::storage()."SQLiteStorage/db.sqlite");

            $this->table_name="objects";
        }

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS ".$this->table_name." (`id` VARCHAR(255) PRIMARY KEY , `data` TEXT, `key` TEXT)");

        $this->pdo->exec("DELETE FROM ".$this->table_name);
    }

    public function store(Distinguishable $distinguishable): void
    {
        $statement = $this->pdo->prepare("INSERT INTO ".$this->table_name." VALUES (:id, :data,:key)");
        $statement->bindValue("id", $distinguishable->key());
        $statement->bindValue("data", serialize($distinguishable));
        $statement->bindValue("key", $distinguishable->key());

        $statement->execute();
    }

    /**
     * @return Distinguishable[]
     */

    public function loadAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM ".$this->table_name);

        $result = [];

        if ($query) {
            foreach ($query->fetchAll(PDO::FETCH_NUM) as $q) {
                $result[] = self::deserializeAsDistinguishable($q[1]);
            }
        }

        return $result;
    }
}
