<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Category;

interface CategoryInterface extends FlyweightSource
{
    /**
     * @param int $id
     * @return Category
     */
    public function get(int $id)/*: ?Category*/;
    public function getAll(): array;
    public function persist(Category $category): CategoryInterface;
    public function persistAll(array $categories): CategoryInterface;
    public function remove(Category $category): bool;
    public function replaceAll(array $categories): CategoryInterface;
}