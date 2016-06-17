<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Academy;

interface AcademyAdapter
{
    public function persist(Academy $academy);
    public function persistBatch(array $academies);
    public function factory($data): Academy;
    public function factoryBatch(array $data): array;
}