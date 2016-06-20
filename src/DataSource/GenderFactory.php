<?php


namespace CampusAppointment\DataSource;


use CampusAppointment\Model\Preset\Gender;

class GenderFactory implements GenderInterface
{
    private $flyweight = [];

    public function get(string $identifier)
    {
        return isset($this->flyweight[$identifier]) ?? ($this->flyweight[$identifier] = new Gender($identifier));
    }

    public static function getDefault(string $identifier)
    {
        static $instance;
        if($instance === null) $instance = new static;
        return $instance->get($identifier);
    }
    
    public static function male()
    {
        return static::getDefault(Gender::MALE);
    }
    
    public static function female()
    {
        return static::getDefault(Gender::FEMALE);
    }

    public static function unknown()
    {
        return static::getDefault(Gender::NA);
    }
    
}