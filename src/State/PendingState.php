<?php


namespace CampusAppointment\State;


use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\Appointment;

class PendingState extends AbstractState
{
    const STATE = 'Q';
    const LABEL = '待确认';
    
    public function change(Appointment $appointment)
    {
        return $appointment->date >= DateUtils::getImmutableToday();
    }

    public function confirm(Appointment $appointment)
    {
        return $appointment->date >= DateUtils::getImmutableToday();
    }

    public function cancel(Appointment $appointment)
    {
        return $appointment->date >= DateUtils::getImmutableToday();
    }

    public function abandon(Appointment $appointment)
    {
        return false;
    }

}