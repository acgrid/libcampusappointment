<?php


namespace CampusAppointment\State;


use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\Preset\Appointment;

class AbandonedState extends AbstractState
{
    const STATE = 'A';
    const LABEL = '已放弃';

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
        return false;
    }

    public function abandon(Appointment $appointment)
    {
        return false;
    }

}