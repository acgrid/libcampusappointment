<?php


namespace CampusAppointmentTest\Model;


use CampusAppointment\Model\Preset\Zone;

class NamedModelTest extends \PHPUnit_Framework_TestCase
{

    public function testZone()
    {
        $zone = new Zone();
        $zone->id = 1;
        $zone->name = 'My Zone';
        $this->assertSame(1, $zone->id);
        $this->assertSame('My Zone', $zone->name);
        $this->assertSame(1, $zone->hashCode());
        $this->assertSame('{"id":1,"name":"My Zone"}', json_encode($zone));
    }
}
