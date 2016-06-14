<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Tutor;

interface TutorInterface extends FlyweightSource
{
    const CONDITION_SCHEDULE = 'schedule';
    
    public function get(int $id): Tutor;
    public function getAll(): array;
    public function find(array $conditions = []): array;
    public function query(array $conditions = [], array $fields = []): array;
    public function persist(Tutor $tutor): TutorInterface;
    public function delete(Tutor $tutor): bool;
    public function persistAll(array $tutors): TutorInterface;
    public function replaceAll(array $tutors): TutorInterface;
    // If cache is implemented, provide a flush method
}