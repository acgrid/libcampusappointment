<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Zone;

interface ZoneAdapter
{
    public function persist(Zone $zone);
    public function persistBatch(array $zones);
    public function factory($data): Zone;
    public function factoryBatch(array $data): array;
}