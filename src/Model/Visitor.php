<?php


namespace CampusAppointment\Model;


abstract class Visitor extends AbstractModel
{
    const LEGACY_SALT_SHA1 = 'LEGACY-SHA1';
    const LABEL = '访问者';
    
    /**
     * Enumeration of visitor if implementing all visitors into one table
     */
    const IDENTITY = '';
    /**
     * Human readable label of this visitor type
     */
    const DESCRIPTION = '';
    /**
     * Human readable label of Unique Identifier of this visitor type
     */
    const UNIQUE_LABEL = '';
    /**
     * Human readable label of Place, like department
     */
    const PLACE_LABEL = '';

    /**
     * Database ID
     * @var int|null
     */
    protected $id;
    /**
     * System specific Unique Identifier
     * @var string
     */
    protected $uniqueIdentifier;
    /**
     * Password Encryption Type
     * Use password_hash() for new applications or previously implemented legacy salted SHA1
     * @var string
     */
    protected $passType = PASSWORD_BCRYPT;
    /**
     * @var string
     */
    protected $passHash = 0x0000000000000000000000000000000000000000;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $age;
    /**
     * @var Gender
     */
    protected $gender;
    /**
     * @var string
     */
    protected $telephone;
    /**
     * @var
     */
    protected $place;

    protected static $readable = ['id', 'uniqueIdentifier', 'name', 'age', 'gender', 'telephone'];
    protected static $writable = ['uniqueIdentifier', 'passType', 'passHash'];

    /**
     * @param string $telephone
     * @return Visitor
     */
    public function setTelephone(string $telephone)
    {
        if(!preg_match('/^[0-9\-]{8,16}$/', $telephone)) throw new \InvalidArgumentException("电话号码 $telephone 格式错误");
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @param Gender $gender
     * @return Visitor
     */
    public function setGender(Gender $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @param int $age
     * @return Visitor
     */
    public function setAge(int $age)
    {
        if($age < 0) throw new \InvalidArgumentException("年龄 $age 无法识别");
        $this->age = $age;
        return $this;
    }

    /**
     * @param string $name
     * @return Visitor
     */
    public function setName(string $name)
    {
        if(mb_strlen($name, 'utf-8') < 2) throw new \InvalidArgumentException("姓名少于2字符");
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        switch($this->passType){
            case self::LEGACY_SALT_SHA1:
                $salt = md5($this->uniqueIdentifier);
                $this->passHash = sha1($salt . $password . $salt);
                break;
            case PASSWORD_DEFAULT:
            case PASSWORD_BCRYPT:
                $this->passHash = password_hash($password, $this->passType);
                break;
            default:
                throw new \RuntimeException('Password encryption is not supported.');
        }
        return $this;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password)
    {
        if(empty($this->passHash)) return false;
        switch($this->passType){
            case self::LEGACY_SALT_SHA1:
                $salt = md5($this->uniqueIdentifier);
                return $this->passHash === sha1($salt . $password . $salt);
            case PASSWORD_DEFAULT:
            case PASSWORD_BCRYPT:
                return password_verify($password, $this->passHash);
            default:
                throw new \RuntimeException('Password encryption is not supported.');
        }
    }
}