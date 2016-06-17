<?php


namespace CampusAppointment\State;


use CampusAppointment\Model\Preset\Appointment;

abstract class AbstractState
{
    const STATE = '';
    const LABEL = '';

    /**
     * @return static
     */
    public static function getInstance()
    {
        static $instance;
        if($instance === null) $instance = new static();
        return $instance;
    }

    /**
     * @param Appointment $appointment
     * @return bool
     */
    abstract public function change(Appointment $appointment);

    /**
     * @param Appointment $appointment
     * @return bool
     */
    abstract public function confirm(Appointment $appointment);

    /**
     * @param Appointment $appointment
     * @return bool
     */
    abstract public function cancel(Appointment $appointment);

    /**
     * @param Appointment $appointment
     * @return bool
     */
    abstract public function abandon(Appointment $appointment);
}