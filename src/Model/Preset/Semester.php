<?php


namespace CampusAppointment\Model\Preset;


use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\FlyweightModel;

class Semester implements FlyweightModel
{
    /**
     * @var array
     */
    protected static $rule = [8, 2];
    /**
     * @var int
     */
    protected $fromYear;
    /**
     * @var int
     */
    protected $half;
    /**
     * @var string
     */
    protected $startDate;
    /**
     * @var string
     */
    protected $tillDate;
    /**+
     * @var \DateTimeImmutable
     */
    protected $cachedStartDate;
    /**
     * @var \DateTimeImmutable
     */
    protected $cachedTillDate;
    /**
     * @var string
     */
    protected $cachedChineseNotation;
    /**
     * @var string
     */
    protected $cachedPackedNotation;

    public function __construct($fromYear, $division)
    {
        $fromYear = (int) $fromYear;
        $division = (int) $division;
        if($fromYear <= 1900 || $division <= 0 || $division > ($total = count(static::$rule))){
            throw new \InvalidArgumentException("学期表示无效");
        }
        $this->fromYear = $fromYear;
        $this->half = $division;
        $this->startDate = sprintf('%u-%u-1',
            ($division == 1 || static::$rule[$division - 1] > static::$rule[$division - 2]) ? $fromYear : $fromYear + 1,
            static::$rule[$division - 1]);
        $this->tillDate = sprintf('%u-%u-1',
            ($division == $total || static::$rule[$division] < static::$rule[$division - 1]) ? $fromYear + 1 : $fromYear,
            static::$rule[$division == $total ? 0 : $division]);
    }

    public static function setRule(array $rule)
    {
        $rule = array_unique(array_filter(array_map('intval', $rule), function ($month) {
            return $month > 0 && $month <= 12;
        }));
        if(empty($rule)) throw new \InvalidArgumentException("Semester rule should contain month integers only.");
        static::$rule = $rule;
    }

    public static function createByDate(\DateTimeInterface $date)
    {
        $year = $date->format('Y');
        $month = $date->format('m');
        $breakpoints = array_merge(static::$rule, [static::$rule[0]]);
        if($month < static::$rule[0]) $year--;
        for($i = 1; $i <= count(static::$rule); $i++){
            if($breakpoints[$i - 1] < $breakpoints[$i]){
                if($month >= $breakpoints[$i - 1] && $month <= $breakpoints[$i]) $division = $i;
            }else{
                if($month >= $breakpoints[$i - 1] || $month <= $breakpoints[$i]) $division = $i;
            }
        }
        if(!isset($division)) throw new \LogicException('Semester division can not be determined.');
        return new static($year, $division);
    }

    public function toChineseNotation(){
        return $this->cachedChineseNotation ?? ($this->cachedChineseNotation =
            sprintf("%u-%u学年第%u学期", $this->fromYear, $this->fromYear + 1, $this->half));
    }

    public function toPackedNotation(){
        return $this->cachedPackedNotation ?? ($this->cachedPackedNotation =
            sprintf("%u-%u-%u", $this->fromYear, $this->fromYear + 1, $this->half));
    }

    public function __toString()
    {
        return $this->toChineseNotation();
    }

    public function hashCode()
    {
        return "$this->fromYear-$this->half";
    }

    public function getStartDate()
    {
        return $this->cachedStartDate ?? ($this->cachedStartDate = DateUtils::getImmutable($this->startDate));
    }

    public function getTillDate()
    {
        return $this->cachedTillDate ?? ($this->cachedTillDate = DateUtils::getImmutable($this->tillDate));
    }
}