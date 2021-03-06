<?php

/**
 *
 * This file is part of the Apix Project.
 *
 * (c) Franck Cassedanne <franck at ouarz.net>
 *
 * @license     http://opensource.org/licenses/BSD-3-Clause  New BSD License
 *
 */

namespace Apix\Cache\Serializer;

class StringsetTest extends TestCase
{

    public function setUp()
    {
        $this->formatter = new Stringset;
    }

    public function serializerProvider()
    {
        return array(
            array(array('a', 'b', 'c'), 'a b c '),
            array(array('juju', 'molly', 'loulou'), 'juju molly loulou '),
            array(array('a-b', 'c', 'd'), 'a-b c d '),
            array(array(), ''),
            array(null, '')
        );
    }

    /**
     * @dataProvider serializerProvider
     */
    public function testSerialize($arr, $str)
    {
        $this->assertEquals( $str, $this->formatter->serialize($arr) );
    }

    public function unserializerProvider()
    {
        return array(
            array(array('a', 'b', 'c'), 'a b c ', 0),
            array(array('a', 'c'), 'a b c -b -x ', 2),
            array(array('c'), 'a b c -b -x -a', 3),
            array(null, 'a  -a', 1)
        );
    }

    /**
     * @dataProvider unserializerProvider
     */
    public function testUnserializer($arr, $str, $dirt)
    {
        $this->assertEquals($arr, $this->formatter->unserialize($str));
        $this->assertEquals($dirt, $this->formatter->getDirtiness());
    }

    public function isSerializerProvider()
    {
        return array(
            array(array('a', 'b', 'c'), 'a b c '),
            array(array('juju', 'molly', 'loulou'), 'juju molly loulou '),
            array(array('a-b', 'c', 'd'), 'a-b c d ')
        );
    }

    /**
     * @dataProvider isSerializerProvider
     */
    public function testIsSerialized($arr, $str)
    {
        $this->assertFalse($this->formatter->isSerialized($arr));
        $this->assertTrue($this->formatter->isSerialized($str));
    }
}
