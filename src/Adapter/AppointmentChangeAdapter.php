<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\AppointmentChange;

interface AppointmentChangeAdapter
{
    public function persist(AppointmentChange $appointmentChange);
    public function persistBatch(array $appointmentChanges);
    public function factory($data): AppointmentChange;
    public function factoryBatch(array $data): array;
}