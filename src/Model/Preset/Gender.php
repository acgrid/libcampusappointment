<?php


namespace CampusAppointment\Model\Preset;


use CampusAppointment\Model\FlyweightModel;

class Gender implements FlyweightModel, \JsonSerializable
{
    const FEMALE = 'F';
    const MALE = 'M';
    const NA = 'N';

    protected $value;
    protected static $labels = [
        self::NA => '未设置',
        self::MALE => '男',
        self::FEMALE => '女',
    ];

    public function __construct(string $value)
    {
        if(!isset(static::$labels[$value])) throw new \InvalidArgumentException("Unknown gender identifier '$value'.");
        $this->value = $value;
    }

    public function hashCode()
    {
        return $this->jsonSerialize();
    }

    public function label()
    {
        return static::$labels[$this->value];
    }

    public static function getLabel($value)
    {
        return static::$labels[$value] ?? '未知性别';
    }

    function jsonSerialize()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}