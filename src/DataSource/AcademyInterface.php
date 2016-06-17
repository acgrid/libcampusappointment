<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Academy;

interface AcademyInterface extends FlyweightSource
{
    public function get(int $id): Academy;
    public function getAll(): array;
    public function persist(Academy $academy): AcademyInterface;
    public function persistAll(array $academies): AcademyInterface;
    public function remove(Academy $academy): bool;
    public function replaceAll(array $academies): AcademyInterface;
}