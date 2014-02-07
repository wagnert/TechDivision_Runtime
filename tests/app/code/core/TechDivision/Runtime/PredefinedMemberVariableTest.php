<?php
/**
 * This file contains a testcase showing a problem with predefined membervariables and the needed testThread.
 *
 * PHP version 5
 *
 * @category   AppServer
 * @package    TechDivision\Runtime
 * @subpackage PthreadProblemPrevention
 * @author     René Rösner <r.roesner@techdivision.com>
 * @copyright  2014 TechDivision GmbH - <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php
 *             Open Software License (OSL 3.0)
 * @link       http://www.techdivision.com/
 */

namespace TechDivision\Runtime;

/**
 * While programming with pthreads an error occured with a membervariable, that was empty although predefined
 * in the descriptionheader of the php class. The observation had been made, that only membervariables set in the
 * constructor are valued in the threadcontext. Currently we are using php in version 5.5.8 .
 *
 * @category   AppServer
 * @package    TechDivision\Runtime
 * @subpackage PthreadProblemPrevention
 * @author     René Rösner <r.roesner@techdivision.com>
 * @copyright  2014 TechDivision GmbH - <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php
 *             Open Software License (OSL 3.0)
 * @link       http://www.techdivision.com/
 */

const CONTAINERKEY = "PredefinedMemberVariableTest";
const EXPECTED     = 1;

class PredefinedMemberVariableTest extends \PHPUnit_Framework_TestCase
{
    protected $testThread;
    protected $testContainer;

    public function setUp()
    {
        $this->testContainer = new TestContainer();
        $this->testThread = new TestThread($this->testContainer);
    }

    public function testPredefinedMemberVariablesContainValues()
    {
        $this->testThread->start();
        $this->testThread->join();

        var_dump($this->testContainer);
        $this->assertEquals(EXPECTED, $this->testContainer[CONTAINERKEY]);
    }
}

class TestThread extends \Thread
{
    protected $predefinedMember = EXPECTED;
    //protected $predefinedMember;
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
        //$this->predefinedMember = EXPECTED;
    }

    public function run()
    {
        $this->container[CONTAINERKEY] = $this->predefinedMember;
    }
}

class TestContainer extends \Stackable
{
    public function run()
    {
    }
}