<?php


namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\ScheduleInterface;
use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Helper\Generator;
use CampusAppointment\Model\Preset\Schedule;
use CampusAppointment\Model\Preset\Tutor;

class ScheduleSampleDB implements ScheduleInterface
{
    private $db;
    private $withTutor = false;

    public function __construct()
    {
        $zoneDS = new ZoneSampleDB();
        $tutorDS = new TutorSampleDB();
        $this->db = [
            1 => (new Schedule($this))->setId(1)->setZone($zoneDS->get(1))->setFromDate(DateUtils::getImmutable('2016-03-01'))->setTillDate(DateUtils::getImmutable('2016-07-31'))->setWeekday(2)->setWeekSpan(0)->setFromTime('13:00')->setTillTime('14:00')->setTutors([$tutorDS->get(1), $tutorDS->get(2)]),
            2 => (new Schedule($this))->setId(2)->setZone($zoneDS->get(2))->setFromDate(DateUtils::getImmutable('2016-03-01'))->setTillDate(DateUtils::getImmutable('2016-07-31'))->setWeekday(5)->setWeekSpan(1)->setFromTime('13:00')->setTillTime('14:00')->setTutors([$tutorDS->get(2)]),
            3 => (new Schedule($this))->setId(3)->setZone($zoneDS->get(1))->setFromDate(DateUtils::getImmutable('2016-03-01'))->setTillDate(DateUtils::getImmutable('2016-07-31'))->setWeekday(2)->setWeekSpan(0)->setFromTime('13:00')->setTillTime('14:00')->setTutors([(new Tutor())->setName('Temporary')]),
        ];
    }

    public function withTutors(): ScheduleInterface
    {
        $this->withTutor = true;
        return $this;
    }

    public function withoutTutors(): ScheduleInterface
    {
        $this->withTutor = false;
        return $this;
    }

    /**
     * @param int $id
     * @return Schedule|null
     */
    public function get(int $id)
    {
        if($schedule = $this->db[$id] ?? null){
            /** @var Schedule $schedule */
            if($this->withTutor) return $schedule;
            $schedule = clone $schedule;
            return $schedule->clearTutors();
        }else{
            return null;
        }
    }

    public function getScheduleTutors(int $id): array
    {
        if($this->db[$id]) return $this->db[$id]->getTutors();
        throw new \InvalidArgumentException('No Such Schedule.');
    }

    public function find(array $conditions = []): array
    {
        return $this->db; // Dummy
    }

    public function query(array $conditions = [], array $fields = []): array
    {
        return array_map(function(Schedule $schedule) use ($fields) {
            return array_intersect_key($schedule->jsonSerialize(), array_flip($fields));
        }, $this->find($conditions));
    }

    public function persist(Schedule $schedule): ScheduleInterface
    {
        if($schedule->id === null) $schedule->id = Generator::nextId($this->db, Schedule::PRIMARY_KEY);
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
        $this->db = [];
        return $this->persistAll($schedules);
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