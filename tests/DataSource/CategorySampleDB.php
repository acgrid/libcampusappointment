<?php


namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\CategoryInterface;
use CampusAppointment\Helper\Generator;
use CampusAppointment\Model\Preset\Category;

class CategorySampleDB implements CategoryInterface
{
    private $db;
    
    public function __construct()
    {
        $this->db = [
            1 => (new Category())->setId(1)->setName('一般咨询'),
            2 => (new Category())->setId(2)->setName('特殊咨询'),
            3 => (new Category())->setId(3)->setName('活动'),
        ];
    }


    public function get(int $id)
    {
        return $this->db[$id] ?? null;
    }

    public function getAll(): array
    {
        return $this->db;
    }

    public function persist(Category $category): CategoryInterface
    {
        if($category->id === null) $category->id = Generator::nextId($this->db, Category::PRIMARY_KEY);
        $this->db[$category->id] = $category;
        return $this;
    }

    public function persistAll(array $categories): CategoryInterface
    {
        array_walk($categories, [$this, 'persist']);
        return $this;
    }

    public function remove(Category $category): bool
    {
        if($has = isset($this->db[$category->id])) unset($this->db[$category->id]);
        return $has;
    }

    public function replaceAll(array $categories): CategoryInterface
    {
        $this->db = [];
        return $this->persistAll($categories);
    }
}