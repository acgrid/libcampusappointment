<?php


namespace CampusAppointment\Model;

/**
 * Class NamedModel
 * @package CampusAppointment\Model
 * @property int|null $id
 * @property string $name
 */
abstract class NamedModel extends AbstractModel implements FlyweightModel
{
    protected $id;
    protected $name;
    protected static $readable = ['id', 'name'];
    protected static $writable = ['name'];

    public function hashCode()
    {
        return $this->id;
    }
}