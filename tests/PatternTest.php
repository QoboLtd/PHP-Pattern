<?php
namespace Qobo\Pattern\Test;

/**
 * Tests for Pattern class
 *
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class PatternTest extends \PHPUnit_Framework_TestCase
{

    public function patterns()
    {
        return array(
        // Pattern,           data,                      expected result
        array('test',         array(),                   'test'),
        array('test%%one%%',  array(),                   'test%%one%%'),
        array('test%%one%%',  array('one'=>''),          'test'),
        array('test%%one%%',  array('test'=>''),         'test%%one%%'),
        array('test%%one%%',  array('foo'=>'bar', 'one'=>'%%two%%', 'two'=>'%%three%%', 'three'=>'%%foo%%'), 'testbar'),
        );
    }
    
    public function patternsEdge()
    {
        return array(
        // Pattern,           data,                      expected result
        array('test',         array(),                   'test'),
        array('test**one**',  array(),                   'test**one**'),
        array('test**one**',  array('one'=>''),          'test'),
        array('test**one**',  array('test'=>''),         'test**one**'),
        );
    }

    /**
     * Simple pattern tests
     *
     * @dataProvider patterns
     */
    public function testSimple($patternString, $data, $expected)
    {
        $pattern = new \Qobo\Pattern\Pattern($patternString);
        $result = $pattern->parse($data);
        $this->assertEquals($expected, $result);

        $result = (string) $pattern;
        $this->assertEquals($expected, $result);
    }
    
    /**
     * Different edge tests
     *
     * @dataProvider patternsEdge
     */
    public function testEdge($patternString, $data, $expected)
    {
        $pattern = new \Qobo\Pattern\Pattern($patternString);
        $pattern->edge = '**';

        $result = $pattern->parse($data);
        $this->assertEquals($expected, $result);
        
        $result = (string) $pattern;
        $this->assertEquals($expected, $result);

    }

    public function testGetPlaceholders()
    {
        $pattern = new \Qobo\Pattern\Pattern('test %%one%% %%two%% %%one%% %%two%% three');
        $result = $pattern->getPlaceholders();
        $this->assertEquals(array('one', 'two'), $result);

        // Pattern without placeholders (issue #10)
        $pattern = new \Qobo\Pattern\Pattern('blah');
        $result = $pattern->getPlaceholders();
        $this->assertTrue(is_array($result));
        $this->assertEmpty($result);
    }
}
