<?php


namespace CampusAppointmentTest\Model;

use CampusAppointment\Model\AbstractModel;
use CampusAppointment\Model\BadFieldException;
use CampusAppointment\Model\RewriteIDException;

/**
 * Class SampleModel
 * @package CampusAppointmentTest\Model
 * @property integer $id
 * @property string $RO
 * @property string $WO
 * @property string $RW
 */
class SampleModel extends AbstractModel{
    protected $id;
    protected $RO = 'Read-only';
    protected $WO = 'Write-only';
    protected $RW = 'Public';

    protected static $reads = ['RO', 'RW'];
    protected static $writes = ['WO', 'RW'];

    public function getRO()
    {
        return "{$this->RO} by getter";
    }

    public function setRW($value)
    {
        $this->RW = "{$value} by setter";
        return $this;
    }
}

class CommonModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SampleModel
     */
    private $sample;
    
    public function setUp()
    {
        $this->sample = new SampleModel();
    }

    public function testGetters()
    {
        $this->assertSame('Read-only by getter', $this->sample->RO);
        try{
            $this->sample->WO;
            $this->fail('An exception shall be thrown on access forbidden properties.');
        }catch (BadFieldException $e){
        }
    }

    public function testSetters()
    {
        $this->sample->WO = 'Overwritten';
        $this->assertSame($this->sample, $this->sample->setId(6));
        $this->sample->RW = 'Updated';
        $this->assertSame('Updated by setter', $this->sample->RW);
        try{
            $this->sample->RO = 'Overwritten';
            $this->fail('An exception shall be thrown on access forbidden properties.');
        }catch (BadFieldException $e){
        }
        try{
            $this->sample->id = 4;
            $this->fail('An exception shall be thrown on rewrite object ID.');
        }catch (RewriteIDException $e){

        }
    }


}