<?php

interface CrudInterface
{

    public function create(array $data);

    public function read(string $id);

    public function readAll(): array;

    public function update(string $id, array $data): bool;

    public function delete(string $id): bool;
}
