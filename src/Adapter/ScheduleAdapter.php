<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Schedule;

interface ScheduleAdapter
{
    public function persist(Schedule $schedule);
    public function persistBatch(array $schedules);
    public function factory($data): Schedule;
    public function factoryBatch(array $data): array;
}