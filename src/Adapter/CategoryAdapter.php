<?php

namespace CampusAppointment\Adapter;

use CampusAppointment\Model\Preset\Category;

interface CategoryAdapter
{
    public function persist(Category $category);
    public function persistBatch(array $categories);
    public function factory($data): Category;
    public function factoryBatch(array $data): array;
}