<?php

namespace Lychee\Support\Data;

interface CrudRepositoryInterface extends RepositoryInterface
{
    public function count(): int;

    public function delete($entity): void;

    public function deleteAll(array $entities = []): void;

    public function deleteById($id): void;

    public function existsById($id): boolean;

    public function findAll(): array;

    public function findAllById(array $ids): array;

    public function findByid($id);

    public function save($entity);

    public function saveAll(array $entities);
}
