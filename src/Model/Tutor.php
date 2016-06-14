<?php


namespace CampusAppointment\Model;

/**
 * Class Tutor
 * @package CampusAppointment\Model
 * @property int $id
 * @property string $name
 * @property Gender $gender
 * @property string $photo
 */
class Tutor extends AbstractModel implements FlyweightModel
{
    const LABEL = '咨询师';
    protected $id;
    protected $name;
    protected $gender;
    protected $photo;
    protected static $readable = ['id', 'name', 'gender', 'photo'];

    public function setName($name){
        if(mb_strlen($name, 'utf-8') < 2) throw new \InvalidArgumentException("咨询师姓名至少2个字符。");
        $this->name = $name;
        return $this;
    }

    public function setGender(Gender $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    public function setPhoto($photo){
        $this->photo = trim($photo);
        return $this;
    }
    
    public function hashCode()
    {
        return $this->id;
    }

}