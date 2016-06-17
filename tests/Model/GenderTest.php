<?php


namespace CampusAppointmentTest\Model;


use CampusAppointment\Model\Preset\Gender;

class GenderTest extends \PHPUnit_Framework_TestCase
{

    public function testGender()
    {
        $female = new Gender(Gender::FEMALE);
        $this->assertSame(Gender::getLabel(Gender::FEMALE), $female->label());
        $this->assertSame(Gender::FEMALE, $female->hashCode());
        $this->assertSame(Gender::FEMALE, strval($female));
    }
}
