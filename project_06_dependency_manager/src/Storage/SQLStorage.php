<?php

namespace Storage;

use Concept\Distinguishable;
use PDO;

class SQLStorage implements Storage
{
    private PDO $pdo;

    public function __construct(string $dsn, string $username = "", string $password = "")
    {
        $this->pdo = new PDO($dsn, $username, $password);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS objects (`key` VARCHAR(256) PRIMARY KEY, `data` TEXT NOT NULL)");
    }

    public function store(Distinguishable $distinguishable): void
    {
        $statement = $this->pdo->prepare("SELECT COUNT(*) FROM objects WHERE `key`=:key");
        $statement->bindValue("key", $distinguishable->key());
        $statement->execute();

        $count = $statement->fetchAll()[0][0];

        if ($count == 0) {
            $statement = $this->pdo->prepare("INSERT INTO objects VALUES (:key, :data)");
        } else {
            $statement = $this->pdo->prepare("UPDATE objects SET `data`=:data WHERE `key`=:key");
        }

        $statement->bindValue('key', $distinguishable->key());
        $statement->bindValue('data', serialize($distinguishable));
        $statement->execute();
    }

    /**
     * @return Distinguishable[]
     */
    public function loadAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM objects");
        if (!$query) {
            exit("Empty query!");
        }
        $objects = $query->fetchAll(PDO::FETCH_OBJ);

        $result = [];

        foreach ($objects as $object) {
            $object = unserialize($object->data);
            if (!$object instanceof Distinguishable) {
                exit("Deserialized object is not a Distinguishable!");
            }
            $result[] = $object;
        }

        return $result;
    }
}
