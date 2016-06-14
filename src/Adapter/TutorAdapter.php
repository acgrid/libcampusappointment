<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Tutor;

interface TutorAdapter
{
    const IDENTITY = '';

    public function persist(Tutor $tutor);
    public function persistBatch(array $tutors);
    public function factory($data): Tutor;
    public function factoryBatch(array $data): array;
}