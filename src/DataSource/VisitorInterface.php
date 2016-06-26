<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Adapter\VisitorAdapter;
use CampusAppointment\Model\Preset\Visitor;

interface VisitorInterface
{
    public function registerAdapter(VisitorAdapter $adapter): VisitorInterface;
    /**
     * @param int $id
     * @return Visitor|null
     */
    public function get(int $id)/*: ?Visitor*/;
    public function find(array $conditions = []): array;
    public function query(array $conditions = [], array $fields = []): array;
    public function persist(Visitor $visitor): VisitorInterface;
    public function persistAll(array $visitors): VisitorInterface;
    public function remove(Visitor $visitor): bool;
}