<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/22
 * Time: 23:54
 */

namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\VisitorInterface;
use CampusAppointment\Model\Preset\Visitor;

class VisitorSampleDB implements VisitorInterface
{
    private $db;

    public function __construct()
    {
        $this->db = [

        ];
    }

    public function registerExtendedSource(callable $detectMethod)
    {
        // TODO: Implement registerExtendedSource() method.
    }

    public function get(int $id): Visitor
    {
        // TODO: Implement get() method.
    }

    public function find(array $conditions = []): array
    {
        // TODO: Implement find() method.
    }

    public function query(array $conditions = [], array $fields = []): array
    {
        // TODO: Implement query() method.
    }

    public function persist(Visitor $visitor): VisitorInterface
    {
        // TODO: Implement persist() method.
    }

    public function remove(Visitor $visitor): bool
    {
        // TODO: Implement remove() method.
    }
}