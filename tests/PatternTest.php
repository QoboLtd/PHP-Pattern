<?php
/**
 * PHP5
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR 
	. '..' . DIRECTORY_SEPARATOR 
	. 'src' . DIRECTORY_SEPARATOR 
	. 'Qobo' . DIRECTORY_SEPARATOR 
	. 'Pattern' . DIRECTORY_SEPARATOR 
	. 'Pattern.php';

/**
 * Tests for Pattern class
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class PatternTest extends PHPUnit_Framework_TestCase {

	public function patterns() {
		return array(
				// Pattern,           data,                      expected result
				array('test',         array(),                   'test'),
				array('test%%one%%',  array(),                   'test%%one%%'),
				array('test%%one%%',  array('one'=>''),          'test'),
				array('test%%one%%',  array('test'=>''),         'test%%one%%'),
				array('test%%one%%',  array('one'=>'%%two%%', 'two'=>'three'), 'testthree'),
			);
	}
	
	public function patternsEdge() {
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
	public function test_simple($patternString, $data, $expected) {
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
	public function test_edge($patternString, $data, $expected) {
		$pattern = new \Qobo\Pattern\Pattern($patternString);
		$pattern->edge = '**';

		$result = $pattern->parse($data);
		$this->assertEquals($expected, $result);
		
		$result = (string) $pattern;
		$this->assertEquals($expected, $result);

	}

	public function test_getPlaceholders() {
		$pattern = new \Qobo\Pattern\Pattern('test %%one%% %%two%% %%one%% %%two%% three');
		$result = $pattern->getPlaceholders();
		$this->assertEquals(array('one', 'two'), $result);
	}
}
?>
