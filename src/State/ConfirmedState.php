<?php


namespace CampusAppointment\State;


use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\Preset\Appointment;

class ConfirmedState extends AbstractState
{
    const STATE = 'C';
    const LABEL = '已确认';
    
    public function change(Appointment $appointment)
    {
        return $appointment->date >= DateUtils::getImmutableToday();
    }

    public function confirm(Appointment $appointment)
    {
        return false;
    }

    public function cancel(Appointment $appointment)
    {
        return $appointment->date >= DateUtils::getImmutableToday();
    }

    public function abandon(Appointment $appointment)
    {
        $today = DateUtils::getImmutableToday();
        return $appointment->date < $today || ($appointment->date == $today && $appointment->schedule->fromTime);
    }

}