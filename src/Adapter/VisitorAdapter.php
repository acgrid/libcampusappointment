<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Visitor;

interface VisitorAdapter
{
    public function persist(Visitor $visitor);
    public function persistBatch(array $visitors);
    public function factory($data): Visitor;
    public function factoryBatch(array $data): array;
}