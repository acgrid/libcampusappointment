<?php


namespace CampusAppointmentTest\DataSource;


use CampusAppointment\DataSource\GenderFactory;
use CampusAppointment\DataSource\TutorInterface;
use CampusAppointment\Helper\Generator;
use CampusAppointment\Model\Preset\Tutor;

class TutorSampleDB implements TutorInterface
{
    private $db;

    public function __construct()
    {
        $this->db = [
            1 => (new Tutor())->setId(1)->setName('Tom')->setGender(GenderFactory::male())->setPhoto('1.jpg'),
            2 => (new Tutor())->setId(2)->setName('Sally')->setGender(GenderFactory::female())->setPhoto('2.jpg'),
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

    public function persist(Tutor $tutor): TutorInterface
    {
        if($tutor->id === null) $tutor->id = Generator::nextId($this->db, Tutor::PRIMARY_KEY);
        $this->db[$tutor->id] = $tutor;
        return $this;
    }

    public function delete(Tutor $tutor): bool
    {
        if($has = isset($this->db[$tutor->id])) unset($this->db[$tutor->id]);
        return $has;
    }

    public function persistAll(array $tutors): TutorInterface
    {
        array_walk($tutors, [$this, 'persist']);
        return $this;
    }

    public function replaceAll(array $tutors): TutorInterface
    {
        $this->db = [];
        return $this->persistAll($tutors);
    }

}