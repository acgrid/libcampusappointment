<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/21
 * Time: 23:31
 */

namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\AppointmentChangeInterface;
use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\Preset\AppointmentChange;
use CampusAppointment\State\AbandonedState;
use CampusAppointment\State\ConfirmedState;

class AppointmentChangesSampleDB implements AppointmentChangeInterface
{
    private $db;
    
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

    public function getDerived(int $appointmentID, $sort = self::DESC): array
    {
        if(!isset($this->db[$appointmentID])) return [];
        return $sort == self::DESC ? array_reverse($this->db[$appointmentID], true) : $this->db[$appointmentID];
    }

    public function persist(AppointmentChange $appointmentChange): AppointmentChangeInterface
    {
        
    }

    public function persistAll(array $appointmentChanges): AppointmentChangeInterface
    {
        // TODO: Implement persistAll() method.
    }

}