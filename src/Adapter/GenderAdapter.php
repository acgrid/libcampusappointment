<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Gender;

interface GenderAdapter
{
    public function persist(Gender $gender);
    public function factory($data): Gender;
}