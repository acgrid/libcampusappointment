<?php


namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\AppointmentInterface;
use CampusAppointment\Helper\Generator;
use CampusAppointment\Model\Preset\Appointment;
use CampusAppointment\Model\Preset\Category;
use CampusAppointment\Model\Preset\Schedule;
use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\Preset\AppointmentChange;
use CampusAppointment\State\AbandonedState;
use CampusAppointment\State\ConfirmedState;

class AppointmentSampleDB implements AppointmentInterface
{
    private $db;
    private $changes;
    private $scheduleDS;
    private $visitorDS;
    private $categoryDS;

    public function __construct()
    {
        $this->scheduleDS = new ScheduleSampleDB();
        $this->visitorDS = new VisitorSampleDB();
        $this->categoryDS = new CategorySampleDB();
        $this->changes = [
            1 => [
                (new AppointmentChange())->setId(1)->setChanged('Confirmed appointment')->setDatetime(DateUtils::getLocal('2016-01-01 08:15:00'))->setIp('127.0.0.1')->setState(ConfirmedState::getInstance())->setPrevious('State: Pending')->setUser(1),
                (new AppointmentChange())->setId(2)->setChanged('Change to schedule #2')->setDatetime(DateUtils::getLocal('2016-01-02 12:35:00'))->setIp('127.0.0.1')->setState(ConfirmedState::getInstance())->setPrevious('Schedule: #1')->setUser(1),
                (new AppointmentChange())->setId(3)->setChanged('Abandoned appointment')->setDatetime(DateUtils::getLocal('2016-01-09 12:35:00'))->setIp('127.0.0.1')->setState(AbandonedState::getInstance())->setPrevious('State: Confirmed')->setUser(2),
            ],
            2 => [
                (new AppointmentChange())->setId(4)->setChanged('Confirmed appointment')->setDatetime(DateUtils::getLocal('2016-01-01 08:15:00'))->setIp('127.0.0.1')->setState(ConfirmedState::getInstance())->setPrevious('State: Pending')->setUser(1),
                (new AppointmentChange())->setId(5)->setChanged('Change to schedule #2')->setDatetime(DateUtils::getLocal('2016-01-02 12:35:00'))->setIp('127.0.0.1')->setState(ConfirmedState::getInstance())->setPrevious('Schedule: #1')->setUser(1)
            ],
        ];
        $this->db = [
            1 => $this->makeAppointment()->setId(1)->setSchedule($this->scheduleDS->get(1))->setDate(DateUtils::getImmutableToday())->setVisitor($this->visitorDS->get(1))->setCreated(DateUtils::getImmutableNow())->setCategories([$this->categoryDS->get(1), (new Category())->setName('特别问题')]),
            2 => $this->makeAppointment()->setId(2)->setSchedule($this->scheduleDS->get(2))->setDate(DateUtils::getImmutableToday())->setVisitor($this->visitorDS->get(2))->setCreated(DateUtils::getImmutableNow())->setCategories([$this->categoryDS->get(2), (new Category())->setName('特别问题2')]),
        ];
    }
    
    public function makeAppointment(): Appointment
    {
        return new Appointment($this->scheduleDS, $this->visitorDS, $this->categoryDS, $this);
    }
    
    public function get(int $id)
    {
        return $this->db[$id] ?? null;
    }

    public function getChanges(int $id): array
    {
        return $this->changes[$id] ?? [];
    }

    public function find(array $conditions = []): array
    {
        return [];
    }

    public function exists(array $conditions = []): bool
    {
        return [];
    }

    public function query(array $conditions = [], array $fields = []): array
    {
        return [];
    }

    public function persist(Appointment $appointment): AppointmentInterface
    {
        if($appointment->id === null) $appointment->id = Generator::nextId($this->db, Appointment::PRIMARY_KEY);
        $this->db[$appointment->id] = $appointment;
        return $this;
    }

    public function persistAll(array $appointments): AppointmentInterface
    {
        array_walk($appointments, [$this, 'persist']);
        return $this;
    }

    public function remove(Appointment $appointment): bool
    {
        if($has = isset($this->db[$appointment->id])) unset($this->db[$appointment->id]);
        return $has;
    }

    public function removeAll(array $appointments): AppointmentInterface
    {
        $this->db = [];
        return $this->persistAll($appointments);
    }

    public function getChangeableSchedules(Schedule $schedule, int $days): array
    {
        // TODO: Implement getChangeableSchedules() method.
    }

    public function isOccupied(Schedule $schedule, \DateTimeInterface $day): bool
    {
        // TODO: Implement isOccupied() method.
    }

    public function getScheduleOccupations(array $schedules, \DateTimeInterface $fromDate, int $weeks): array
    {
        // TODO: Implement getScheduleOccupations() method.
    }

}