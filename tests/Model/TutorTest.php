<?php


namespace CampusAppointmentTest\Model;


use CampusAppointment\Model\Preset\Gender;
use CampusAppointment\Model\Preset\Tutor;

class TutorTest extends \PHPUnit_Framework_TestCase
{

    public function testSetters()
    {
        $tutor = new Tutor();
        $this->assertSame($tutor, $tutor->setName('姓名'));
        $this->assertSame($tutor, $tutor->setGender(new Gender(Gender::FEMALE)));
        $this->assertSame($tutor, $tutor->setPhoto(" http://a.rip/1.jpg\n"));
        $this->assertSame('姓名', $tutor->name);
        $this->assertSame(Gender::FEMALE, $tutor->gender->jsonSerialize());
        $this->assertSame('http://a.rip/1.jpg', $tutor->photo);
        try{
            $this->setName('a');
            $this->fail('Should throw an exception about name.');
        }catch (\Exception $e){

        }
    }

}
