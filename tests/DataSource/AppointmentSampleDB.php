<?php


namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\AppointmentInterface;
use CampusAppointment\Model\Preset\Appointment;
use CampusAppointment\Model\Preset\Schedule;
use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\Preset\AppointmentChange;
use CampusAppointment\State\AbandonedState;
use CampusAppointment\State\ConfirmedState;

class AppointmentSampleDB implements AppointmentInterface
{
    private $db;
    private $scheduleDS;
    private $visitorDS;
    private $categoryDS;

    public function __construct()
    {
        $this->db = [
            
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
    }
    
    public function makeAppointment(): Appointment
    {
        
    }
    
    public function get(int $id): Appointment
    {
        // TODO: Implement get() method.
    }

    public function getChanges(int $id): array
    {
        // TODO: Implement getChanges() method.
    }

    public function find(array $conditions = []): array
    {
        // TODO: Implement find() method.
    }

    public function exists(array $conditions = []): bool
    {
        // TODO: Implement exists() method.
    }

    public function query(array $conditions = [], array $fields = []): array
    {
        // TODO: Implement query() method.
    }

    public function persist(Appointment $appointment): AppointmentInterface
    {
        // TODO: Implement persist() method.
    }

    public function persistAll(array $appointments): AppointmentInterface
    {
        // TODO: Implement persistAll() method.
    }

    public function remove(Appointment $appointment): bool
    {
        // TODO: Implement remove() method.
    }

    public function removeAll(array $appointments): AppointmentInterface
    {
        // TODO: Implement removeAll() method.
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