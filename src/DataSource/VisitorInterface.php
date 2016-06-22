<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Visitor;

interface VisitorInterface
{
    public function registerExtendedSource(callable $detectMethod);
    public function get(int $id): Visitor;
    public function find(array $conditions = []): array;
    public function query(array $conditions = [], array $fields = []): array;
    public function persist(Visitor $visitor): VisitorInterface;
    public function remove(Visitor $visitor): bool;
}