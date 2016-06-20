<?php


namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\CategoryInterface;
use CampusAppointment\Model\Preset\Category;

class CategorySampleDB implements CategoryInterface
{
    

    public function get(int $id): Category
    {
        // TODO: Implement get() method.
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function persist(Category $category): CategoryInterface
    {
        // TODO: Implement persist() method.
    }

    public function persistAll(array $categories): CategoryInterface
    {
        // TODO: Implement persistAll() method.
    }

    public function remove(Category $category): bool
    {
        // TODO: Implement remove() method.
    }

    public function replaceAll(array $categories): CategoryInterface
    {
        // TODO: Implement replaceAll() method.
    }
}