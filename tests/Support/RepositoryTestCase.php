<?php

namespace Tests\Support;

use PDO;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

abstract class RepositoryTestCase extends TestCase
{
    protected PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    protected function repository(string $className): object
    {
        $reflection = new ReflectionClass($className);
        $repository = $reflection->newInstanceWithoutConstructor();

        $property = $reflection->getProperty('pdo');
        $property->setAccessible(true);
        $property->setValue($repository, $this->pdo);

        return $repository;
    }
}
