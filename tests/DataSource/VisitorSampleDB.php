<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/22
 * Time: 23:54
 */

namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\VisitorAbstractSource;
use CampusAppointment\DataSource\VisitorInterface;
use CampusAppointment\Model\Preset\Visitor;
use CampusAppointmentTest\Adapter\StudentVisitorAdapter;

class VisitorSampleDB extends VisitorAbstractSource
{
    private $db;
    
    public function __construct()
    {
        $this->registerAdapter(new StudentVisitorAdapter());
        $this->db = [
            1 => ['id' => 1, 'name' => 'Adam', 'gender' => 'M', 'age' => 19, 'identity' => 'S', 'telephone' => '13985154311', 'place' => 'SE', 'passhash' => Visitor::NO_PASSWORD],
        ];
    }

    public function get(int $id)/*: ?Visitor*/
    {
        return isset($this->db[$id]) ? $this->iterateFactory($this->db[$id]) : null;
    }

    public function find(array $conditions = []): array
    {
        throw new \BadMethodCallException('This method is not supported in sample object.');
    }

    public function query(array $conditions = [], array $fields = []): array
    {
        throw new \BadMethodCallException('This method is not supported in sample object.');
    }

    public function persist(Visitor $visitor): VisitorInterface
    {
        $this->iteratePersist($visitor);
        return $this;
    }

    public function persistAll(array $visitors): VisitorInterface
    {
        array_walk($visitors, [$this, 'persist']);
    }

    public function remove(Visitor $visitor): bool
    {
        if($has = isset($this->db[$visitor->id])) unset($this->db[$visitor->id]);
        return $has;
    }

}