<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Tutor;

interface TutorInterface extends FlyweightSource
{
    /**
     * @param int $id
     * @return Tutor|null
     */
    public function get(int $id)/*: ?Tutor*/;
    public function getAll(): array;
    public function persist(Tutor $tutor): TutorInterface;
    public function delete(Tutor $tutor): bool;
    public function persistAll(array $tutors): TutorInterface;
    public function replaceAll(array $tutors): TutorInterface;
    // If cache is implemented, provide a flush method
}