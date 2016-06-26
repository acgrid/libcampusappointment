<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/22
 * Time: 23:14
 */

namespace CampusAppointmentTest\DataSource;

use CampusAppointment\DataSource\ZoneInterface;
use CampusAppointment\Helper\Generator;
use CampusAppointment\Model\Preset\Zone;

class ZoneSampleDB implements ZoneInterface
{
    private $db;

    public function __construct()
    {
        $this->db = [
            1 => (new Zone())->setId(1)->setName('Zone A'),
            2 => (new Zone())->setId(2)->setName('Zone B'),
        ];
    }

    public function get(int $id)
    {
        return $this->db[$id] ?? null;
    }

    public function getAll(): array
    {
        return $this->db;
    }

    public function persist(Zone $zone): ZoneInterface
    {
        if($zone->id === null) $zone->id = Generator::nextId($this->db, Zone::PRIMARY_KEY);
        $this->db[$zone->id] = $zone;
        return $this;
    }

    public function persistAll(array $zones): ZoneInterface
    {
        array_walk($zones, [$this, 'persist']);
        return $this;
    }

    public function remove(Zone $zone): bool
    {
        if($has = isset($this->db[$zone->id])) unset($this->db[$zone->id]);
        return $has;
    }

    public function replaceAll(array $zones): ZoneInterface
    {
        $this->db = [];
        return $this->persistAll($zones);
    }

}