<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Propel\Bundle\PropelBundle\Tests\DataCollector;

use Propel\Bundle\PropelBundle\DataCollector\PropelDataCollector;
use Propel\Bundle\PropelBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PropelDataCollectorTest extends TestCase
{
    public function testCollectWithoutData()
    {
        $c = $this->createCollector(array());
        $c->collect(new Request(), new Response());

        $this->assertEquals(array(), $c->getQueries());
        $this->assertEquals(0, $c->getQueryCount());
    }

    public function testCollectWithData()
    {
        $queries = array(
            "time: 0.000 sec | mem: 1.4 MB | connection: default | SET NAMES 'utf8'",
        );

        $c = $this->createCollector($queries);
        $c->collect(new Request(), new Response());

        $this->assertEquals(array(
            array(
                'sql' => "SET NAMES 'utf8'",
                'time' => '0.000 sec',
                'connection' => 'default',
                'memory' => '1.4 MB',
            ),
        ), $c->getQueries());
        $this->assertEquals(1, $c->getQueryCount());
    }

    public function testCollectWithMultipleData()
    {
        $queries = array(
            "time: 0.000 sec | mem: 1.4 MB | connection: default | SET NAMES 'utf8'",
            'time: 0.012 sec | mem: 2.4 MB | connection: default | SELECT tags.NAME, image.FILENAME FROM tags LEFT JOIN image ON tags.IMAGEID = image.ID WHERE image.ID = 12',
            "time: 0.012 sec | mem: 2.4 MB | connection: default | INSERT INTO `table` (`some_array`) VALUES ('| 1 | 2 | 3 |')",
        );

        $c = $this->createCollector($queries);
        $c->collect(new Request(), new Response());

        $this->assertEquals(array(
            array(
                'sql' => "SET NAMES 'utf8'",
                'time' => '0.000 sec',
                'connection' => 'default',
                'memory' => '1.4 MB',
            ),
            array(
                'sql' => 'SELECT tags.NAME, image.FILENAME FROM tags LEFT JOIN image ON tags.IMAGEID = image.ID WHERE image.ID = 12',
                'time' => '0.012 sec',
                'connection' => 'default',
                'memory' => '2.4 MB',
            ),
            array(
                'sql' => "INSERT INTO `table` (`some_array`) VALUES ('| 1 | 2 | 3 |')",
                'time' => '0.012 sec',
                'connection' => 'default',
                'memory' => '2.4 MB',
            ),
        ), $c->getQueries());
        $this->assertEquals(3, $c->getQueryCount());
        $this->assertEquals(0.024, $c->getTime());
    }

    private function createCollector($queries)
    {
        $config = $this->getMockBuilder('\PropelConfiguration')->getMock();

        $config
            ->expects($this->any())
            ->method('getParameter')
            ->will($this->returnArgument(1))
        ;

        $logger = $this->getMockBuilder('\Propel\Bundle\PropelBundle\Logger\PropelLogger')->getMock();
        $logger
            ->expects($this->any())
            ->method('getQueries')
            ->will($this->returnValue($queries))
        ;

        return new PropelDataCollector($logger, $config);
    }
}
