<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Visitor;

interface VisitorInterface
{
    public function registerVariant(VisitorInterface $visitorDS);
    public function get(int $id): Visitor;
    public function find(array $conditions = []): array;
    public function query(array $conditions = [], array $fields = []): array;
    public function persist(Visitor $visitor): VisitorInterface;
    public function persistAll(array $visitors): VisitorInterface;
    public function remove(Visitor $visitor): bool;
}