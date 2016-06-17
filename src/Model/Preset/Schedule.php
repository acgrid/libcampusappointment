<?php


namespace CampusAppointment\Model\Preset;

use CampusAppointment\DataSource\TutorInterface;
use CampusAppointment\Helper\DateUtils;
use CampusAppointment\Model\AbstractModel;
use CampusAppointment\Model\FlyweightModel;
use \DateInterval;

/**
 * Class Schedule
 * @package CampusAppointment\Model
 * @property int $id
 * @property Zone $zone
 * @property bool $enabled
 * @property \DateTimeImmutable $fromDate
 * @property \DateTimeImmutable $tillDate
 * @property int $weekday
 * @property int $weekSpan
 * @property int $fromTime
 * @property int $tillTime
 * @property array $tutors
 */
class Schedule extends AbstractModel implements FlyweightModel
{
    const LABEL = '预约时段';

    /**
     * @var TutorInterface
     */
    protected $tutorDS;
    
    protected $id;
    /**
     * @var Zone
     */
    protected $zone;
    /**
     * @var bool
     */
    protected $enabled;
    /**
     * @var \DateTimeImmutable
     */
    protected $fromDate;
    /**
     * @var \DateTimeImmutable
     */
    protected $tillDate;
    /**
     * 0 for everyday, 1(Monday)-7(Sunday) for specific weekday
     * @var int
     */
    protected $weekday;
    /**
     * @var int
     */
    protected $weekSpan;
    /**
     * Seconds in a single day
     * @var int
     */
    protected $fromTime;
    /**
     * @var int
     */
    protected $tillTime;
    /**
     * @var array
     */
    protected $tutors;

    protected static $readable = ['id', 'zone', 'enabled', 'fromDate', 'tillDate', 'weekday', 'weekSpan',
        'fromTime', 'tillTime'];
    
    public function __construct(TutorInterface $tutorDS)
    {
        $this->tutorDS = $tutorDS;
    }

    /**
     * @param Zone $zone
     * @return $this
     */
    public function setZone(Zone $zone)
    {
        $this->zone = $zone;
        return $this;
    }

    /**
     * @param boolean $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;
        return $this;
    }

    /**
     * @param \DateTimeInterface $fromDate
     * @return $this
     */
    public function setFromDate(\DateTimeInterface $fromDate)
    {
        $this->fromDate = $fromDate instanceof \DateTime ? \DateTimeImmutable::createFromMutable($fromDate) : $fromDate;
        return $this;
    }

    /**
     * @param \DateTimeImmutable $tillDate
     * @return $this
     */
    public function setTillDate($tillDate)
    {
        $this->tillDate = $tillDate instanceof \DateTime ? \DateTimeImmutable::createFromMutable($tillDate) : $tillDate;
        return $this;
    }

    /**
     * @param int $weekday
     * @return $this
     */
    public function setWeekday(int $weekday)
    {
        if($weekday < 0 || $weekday > 7) throw new \InvalidArgumentException('星期序号应在 0 到 7 之间');
        $this->weekday = $weekday;
        return $this;
    }

    /**
     * @param int $weekSpan
     * @return $this
     */
    public function setWeekSpan(int $weekSpan)
    {
        if($weekSpan < 0 || $weekSpan > 2) throw new \InvalidArgumentException('星期跨度应在 0 到 2 之间');
        $this->weekSpan = $weekSpan;
        return $this;
    }

    /**
     * @param int|string $fromTime
     * @return $this
     */
    public function setFromTime($fromTime)
    {
        if(is_string($fromTime)){
            $this->fromTime = DateUtils::convertTimeToDaySec($fromTime);
        }elseif(is_integer($fromTime) && $fromTime >= 0 && $fromTime < 86400){
            $this->fromTime = $fromTime;
        }else{
            throw new \InvalidArgumentException('起始时段无法识别。');
        }
        return $this;
    }

    /**
     * @param int|string $tillTime
     * @return $this
     */
    public function setTillTime(int $tillTime)
    {
        if(is_string($tillTime)){
            $this->tillTime = DateUtils::convertTimeToDaySec($tillTime);
        }elseif(is_integer($tillTime) && $tillTime >= 0 && $tillTime < 86400){
            $this->tillTime = $tillTime;
        }else{
            throw new \InvalidArgumentException('起始时段无法识别。');
        }
        return $this;
    }

    public function hashCode()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getTutors()
    {
        if($this->tutors === null && $this->id){
            $this->tutors = $this->tutorDS->find([TutorInterface::CONDITION_SCHEDULE => $this->id]);
        }
        return $this->tutors ?? [];
    }

    /**
     * @param array $tutors
     * @return Schedule
     */
    public function setTutors(array $tutors)
    {
        $this->tutors = array_filter($tutors, function($tutor){
            return $tutor instanceof Tutor;
        });
        return $this;
    }

    protected function ensureValid()
    {
        if($this->fromDate > $this->tillDate) throw new \LogicException('时段起始日期大于结束日期。');
        if($this->fromTime > $this->tillTime) throw new \LogicException('时段起始时间大于结束时间。');
        return $this;
    }

    public function getHappenDates(\DateTimeInterface $fromDate, int $weeks, \DateTimeInterface $tillDate = null)
    {
        static $pOneDay, $pOneWeek, $pTwoWeeks, $dateInfinite;
        $this->ensureValid();
        if(is_null($pOneDay)) $pOneDay = new DateInterval('P1D');
        if(is_null($pOneWeek)) $pOneWeek = new DateInterval('P1W');
        if(is_null($pTwoWeeks)) $pTwoWeeks = new DateInterval('P2W');
        if(is_null($dateInfinite)) $dateInfinite = DateUtils::getImmutable('9999-12-31');

        if(!is_null($tillDate) && $tillDate < $fromDate) throw new \InvalidArgumentException("终止日期小于起始日期");
        if(is_null($tillDate)) $tillDate = $dateInfinite;
        if(!is_numeric($weeks) || $weeks <= 0) throw new \InvalidArgumentException("获取周数必须为整数");
        if($fromDate < $this->fromDate) $fromDate = clone $this->fromDate;
        $dates = [];
        if($this->weekday == 0){ // everyday, just fill from the fromDate
            $current_date = clone $fromDate;
            $remain_days = $weeks * 7;
            while($remain_days > 0 && $current_date < $tillDate && $current_date <= $this->tillDate){
                $dates[] = clone $current_date; // save modified object
                $current_date->add($pOneDay); // modify $current_date itself!
                $remain_days--;
            }
        }else{
            $current_date = clone $fromDate;
            $from_weekday = (int) $fromDate->format('N'); // ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)
            // Offset the week span
            if($this->weekSpan > 0){
                $interval = $pTwoWeeks;
                $week_a_loop = 2;
                $fromWeekSpan = 2 - (((int) $fromDate->format('W')) % 2); // From odd/even week?
                if($this->weekSpan != $fromWeekSpan){
                    $current_date->add(new DateInterval(sprintf('P%uD',$this->weekday + (7 - $from_weekday)))); // Offset *current_date* to next *corresponding* week
                    if($current_date->format('N') <> $this->weekday) throw new \LogicException("Bad Logic #4");
                    $from_weekday = $this->weekday; // Should be at the same position
                    if($weeks == 1 || $current_date > $tillDate || $current_date > $this->tillDate) return $dates; // Whether violates the constraint?
                }
            }else{
                $interval = $pOneWeek;
                $week_a_loop = 1;
            }
            // Offset the weekday
            $remain_weeks = $weeks;
            if($from_weekday < $this->weekday){ // later in this week
                $current_date->add(new DateInterval(sprintf('P%uD',$this->weekday - $from_weekday)));
            }elseif($from_weekday > $this->weekday){ // goto next week
                $current_date->add(new DateInterval(sprintf('P%uD',$this->weekday + (7 - $from_weekday))));
                $remain_weeks--;
            } // no else: $current_date is just equal $fromDate in value!
            // Loop
            while($remain_weeks > 0 && $current_date <= $tillDate && $current_date <= $this->tillDate){
                if($current_date <= $tillDate) $dates[] = clone $current_date; // save modified object
                $current_date->add($interval); // modify $current_date itself!
                $remain_weeks -= $week_a_loop;
            }
        }
        return $dates;
    }

    public function testConflicts(array $schedules)
    {
        $this->ensureValid();
        foreach($schedules as $schedule){
            /**
             * @var Schedule $schedule
             */
            // determine the intersected date duration
            $intersected_fromDate = $this->fromDate > $schedule->fromDate ? $this->fromDate : $schedule->fromDate;
            $intersected_tillDate = $this->tillDate < $schedule->tillDate ? $this->tillDate : $schedule->tillDate;
            if($intersected_fromDate > $intersected_tillDate) throw new \LogicException("Out of intersected range #1"); // continue; // never meet if OK, for debug
            // determine the intersected time duration
            $intersected_fromTime = $this->fromTime > $schedule->fromTime ? $this->fromTime : $schedule->fromTime;
            $intersected_tillTime = $this->tillTime < $schedule->tillTime ? $this->tillTime : $schedule->tillTime;
            if($intersected_fromTime > $intersected_tillTime) throw new \LogicException("Out of intersected range #2"); // continue; // never meet if OK, for debug
            // determine whether has same time point to conflict
            if($this->weekday == 0 || $schedule->weekday == 0){ // must be conflict at the first day
                $conflict['id'] = $schedule->id;
                $conflict['date'] = $intersected_fromDate;
                $conflict['from'] = DateUtils::convertDaySecToTime($intersected_fromTime);
                $conflict['till'] = DateUtils::convertDaySecToTime($intersected_tillTime);
                return $conflict; // find first conflict
            }else{ // maybe conflict on specific weekday
                $my_happens = $this->getHappenDates($intersected_fromDate, 3, $intersected_tillDate);
                $his_happens = $schedule->getHappenDates($intersected_fromDate, 3, $intersected_tillDate);
                if(empty($my_happens) || empty($his_happens)) return false; // in fact no happens in these intersected days
                foreach($my_happens as $my_happen){
                    foreach($his_happens as $his_happen){
                        if($my_happen == $his_happen){
                            $conflict['id'] = $schedule->id;
                            $conflict['date'] = $my_happen;
                            $conflict['from'] = DateUtils::convertDaySecToTime($intersected_fromTime);
                            $conflict['till'] = DateUtils::convertDaySecToTime($intersected_tillTime);
                            return $conflict;
                        }
                    }
                }
            }
        }
        return [];
    }
}