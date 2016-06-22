<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Schedule;

interface ScheduleInterface extends FlyweightSource
{
    public function withTutors(): ScheduleInterface;
    public function withoutTutors(): ScheduleInterface;
    public function get(int $id): Schedule;
    public function getScheduleTutors(int $id): array;
    public function find(array $conditions = []): array;
    public function query(array $conditions = [], array $fields = []): array;
    public function persist(Schedule $schedule): ScheduleInterface;
    public function remove(Schedule $schedule): bool;
    public function persistAll(array $schedules): ScheduleInterface;
    public function replaceAll(array $schedules): ScheduleInterface;
    public function isConflict(Schedule $schedule);

}