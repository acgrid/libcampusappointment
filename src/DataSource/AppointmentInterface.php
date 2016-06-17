<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Appointment;
use CampusAppointment\Model\Preset\Schedule;

interface AppointmentInterface extends FlyweightSource
{
    const WITH_SCHEDULE = 'S';
    const WITH_VISITOR = 'V';
    const CONDITION_VISITOR_UNIQUE_ID = '';
    const CONDITION_FUTURE_NATURAL_WEEK = '';
    const CONDITION_PAST_NATURAL_WEEK = '';
    const CONDITION_FUTURE_FOLLOWING_WEEK = '';
    const CONDITION_PAST_FOLLOWING_WEEK = '';
    const CONDITION_STATES_IN = '';

    public function get(int $id): Appointment;
    public function find(array $conditions = []): array;
    public function exists(array $conditions = []): bool;
    public function query(array $conditions = [], array $fields = []): array;
    public function persist(Appointment $appointment): AppointmentInterface;
    public function persistAll(array $appointments): AppointmentInterface;
    public function remove(Appointment $appointment): bool;
    public function removeAll(array $appointments): AppointmentInterface;
    public function getChangeableSchedules(Schedule $schedule, int $days): array;
    public function isOccupied(Schedule $schedule, \DateTimeInterface $day): bool;
    public function getScheduleOccupations(array $schedules, \DateTimeInterface $fromDate, int $weeks): array;
}