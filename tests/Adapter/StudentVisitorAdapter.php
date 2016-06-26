<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/26
 * Time: 14:36
 */

namespace CampusAppointmentTest\Adapter;


use CampusAppointment\Adapter\VisitorAdapter;
use CampusAppointment\Helper\PlainArrayPersistTrait;
use CampusAppointment\Model\Preset\Gender;
use CampusAppointment\Model\Preset\Visitor;
use CampusAppointmentTest\Model\Student;

class StudentVisitorAdapter implements VisitorAdapter
{
    use PlainArrayPersistTrait;
    
    public function __construct()
    {
        $this->requireKey('gender', function(Student $object, $value, &$array){
            $object->setGender(new Gender($value));
        }, function(Visitor $object){
            return $object->gender->jsonSerialize();
        });

    }

    public function getTargetClass(): string
    {
        return Student::class;
    }
    
    public function persist(Visitor $visitor)
    {
        if(!($visitor instanceof Student)) throw new \InvalidArgumentException("Accept student instance only.");
        $array = $visitor->jsonSerialize();
        $array['identity'] = Student::IDENTITY;
        return $this->setArray($visitor);
    }

    public function persistBatch(array $visitors)
    {
        return array_map([$this, 'persist'], $visitors);
    }

    public function tryFactory($data)
    {
        if(isset($data['identity']) && $data['identity'] === Student::IDENTITY){
            return $this->factory($data);
        }else{
            return false;
        }
    }

    public function factory($data): Visitor
    {
        return $this->setObject($data, new Student());
    }

    public function factoryBatch(array $data): array
    {
        return array_map([$this, 'factory'], $data);
    }

}