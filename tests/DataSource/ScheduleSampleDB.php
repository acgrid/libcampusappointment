<?php


namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\ScheduleInterface;
use CampusAppointment\Model\Preset\Schedule;

class ScheduleSampleDB implements ScheduleInterface
{
    private $db;
    private $withTutor = false;

    public function __construct()
    {
        $this->db = [
            1 => (new Schedule($this))->setId(1),
            2 => (new Schedule($this))->setId(2),
            3 => (new Schedule($this))->setId(3),
        ];
    }

    public function withTutors()
    {
        $this->withTutor = true;
        return $this;
    }

    public function withoutTutors()
    {
        $this->withTutor = false;
        return $this;
    }

    public function get(int $id): Schedule
    {
        return $this->db[$id] ?? null;
    }

    public function getTutors(int $id): array
    {
        return $this->db;
    }

    public function find(array $conditions = []): array
    {
        // TODO: Implement find() method.
    }

    public function query(array $conditions = [], array $fields = []): array
    {
        // TODO: Implement query() method.
    }

    public function persist(Schedule $schedule): ScheduleInterface
    {
        $this->db[$schedule->id] = $schedule;
        return $this;
    }

    public function remove(Schedule $schedule): bool
    {
        if($has = isset($this->db[$schedule->id])) unset($this->db[$schedule->id]);
        return $has;
    }

    public function persistAll(array $schedules): ScheduleInterface
    {
        array_walk($schedules, [$this, 'persist']);
        return $this;
    }

    public function replaceAll(array $schedules): ScheduleInterface
    {
        $this->db = array_filter($schedules, function($schedule){
            return $schedule instanceof Schedule;
        });
        return $this;
    }

    public function isConflict(Schedule $schedule)
    {
        return $schedule->testConflicts(array_filter($this->db, function(Schedule $current) use ($schedule){
            if($current == $schedule || $schedule->zone <> $current->zone) return false;
            return $current->fromDate < $schedule->tillDate && $current->tillDate > $schedule->fromDate
            && $current->fromTime < $schedule->tillTime && $current->tillTime > $schedule->fromTime;
        }));
    }

}