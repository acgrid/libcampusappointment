<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\AppointmentChange;

interface AppointmentChangeInterface
{
    const ASC = 'ASC';
    const DESC = 'DESC';
    
    public function getDerived(int $appointmentID, $sort = self::DESC): array;
    public function persist(AppointmentChange $appointmentChange): AppointmentChangeInterface;
    public function persistAll(array $appointmentChanges): AppointmentChangeInterface;
}