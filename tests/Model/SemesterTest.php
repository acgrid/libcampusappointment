<?php


namespace CampusAppointmentTest\Model;


use CampusAppointment\Model\Preset\Semester;

class SemesterTest extends \PHPUnit_Framework_TestCase
{

    public function testRanges()
    {
        $semester = new Semester(2015, 1);
        $this->assertSame('2015-2016学年第1学期', strval($semester));
        $this->assertSame('2015-2016学年第1学期', $semester->toChineseNotation());
        $this->assertSame('2015-2016-1', $semester->toPackedNotation());
        $this->assertSame('2015-1', $semester->hashCode());
        $this->assertSame('2015-08-01', $semester->getStartDate()->format('Y-m-d'));
        $this->assertSame('2016-02-01', $semester->getTillDate()->format('Y-m-d'));
        Semester::setRule([9, 2]);
        $this->assertSame('2015-08-01', $semester->getStartDate()->format('Y-m-d'));
        $this->assertSame('2016-02-01', $semester->getTillDate()->format('Y-m-d'));
        $semester2 = new Semester(2015, 1);
        $this->assertSame('2015-09-01', $semester2->getStartDate()->format('Y-m-d'));
        $this->assertSame('2015-2016-1', Semester::createByDate(new \DateTimeImmutable('2015-11-11'))->toPackedNotation());
        $this->assertSame('2015-2016-2', Semester::createByDate(new \DateTimeImmutable('2016-08-15'))->toPackedNotation());
    }

    public function testBad()
    {
        $this->setExpectedException('InvalidArgumentException', '学期表示无效');
        new Semester(2016, 0);
    }

    public function testTripleSemesters()
    {
        Semester::setRule([7, 10, 2]);
        $first = new Semester(2015, 1);
        $second = new Semester(2015, 2);
        $third = new Semester(2015, 3);
        $this->assertSame('2015-07-01', $first->getStartDate()->format('Y-m-d'));
        $this->assertSame('2015-10-01', $second->getStartDate()->format('Y-m-d'));
        $this->assertSame('2016-02-01', $third->getStartDate()->format('Y-m-d'));
        $this->assertSame('2015-2016-1', Semester::createByDate(new \DateTimeImmutable('2015-08-15'))->toPackedNotation());
        $this->assertSame('2015-2016-2', Semester::createByDate(new \DateTimeImmutable('2016-01-10'))->toPackedNotation());
        $this->assertSame('2015-2016-3', Semester::createByDate(new \DateTimeImmutable('2016-03-11'))->toPackedNotation());
    }


}
