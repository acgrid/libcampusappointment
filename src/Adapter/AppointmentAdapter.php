<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Appointment;

interface AppointmentAdapter
{
    public function persist(Appointment $appointment);
    public function persistBatch(array $appointments);
    public function factory($data): Appointment;
    public function factoryBatch(array $data): array;
}