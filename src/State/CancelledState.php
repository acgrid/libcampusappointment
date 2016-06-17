<?php


namespace CampusAppointment\State;


use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\Preset\Appointment;

class CancelledState extends AbstractState
{
    const STATE = 'D';
    const LABEL = '已取消';
    
    public function change(Appointment $appointment)
    {
        return true;
    }

    public function confirm(Appointment $appointment)
    {
        return $appointment->date >= DateUtils::getImmutableToday();
    }

    public function cancel(Appointment $appointment)
    {
        return false;
    }

    public function abandon(Appointment $appointment)
    {
        return false;
    }

}