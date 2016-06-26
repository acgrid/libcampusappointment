<?php


namespace CampusAppointmentTest\Model;


use CampusAppointment\Model\Preset\Schedule;
use CampusAppointmentTest\DataSource\ScheduleSampleDB;

class ScheduleTest extends \PHPUnit_Framework_TestCase
{

    public function testSchedule()
    {
        $schedule = new Schedule(new ScheduleSampleDB());
    }

}
