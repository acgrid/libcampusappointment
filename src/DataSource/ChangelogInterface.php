<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\AppointmentChange;

interface ChangelogInterface
{
    public function getByAppointment(int $appointmentID): array;
    public function persist(AppointmentChange $appointmentChange): ChangelogInterface;
    public function persistAll(array $appointmentChanges): ChangelogInterface;
    
}