<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Zone;

interface ZoneInterface extends FlyweightSource
{
    public function get(int $id): Zone;
    public function getAll(): array;
    public function persist(Zone $zone): ZoneInterface;
    public function persistAll(array $zones): ZoneInterface;
    public function remove(Zone $zone): bool;
    public function replaceAll(array $zones): ZoneInterface;
}