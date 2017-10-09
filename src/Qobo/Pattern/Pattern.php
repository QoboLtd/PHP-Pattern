<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Qobo\Pattern;

/**
 * Pattern class
 *
 * This class provides an easy way of creating patterns with
 * placeholders and then rendering them with given content.
 *
 * @author Leonid Mamchenkov <l.mamchenkov@qobo.biz>
 */
class Pattern
{

    protected $pattern;
    protected $data;

    /**
     * Placeholder edge separator
     *
     * Use this in the pattern to set placeholders, for example: "Hello %%fullname%%".
     * For simplicity reasons, the starting and ending edge separator is the same.
     */
    public $edge = '%%';

    /**
     * Constructor
     *
     * @param string $pattern Pattern content
     * @param string $data    (Optional) Data to render with
     */
    public function __construct($pattern, array $data = array())
    {
        $this->pattern = $pattern;
        $this->data = $data;
    }
    
    /**
     * Parse pattern, fill with data
     *
     * This method will populate the pattern with provided data.  Placeholders are
     * case sensitive.  Any placeholder that hasn't been provided the data for, will
     * remain in result, to avoid any accidental loss of strings.
     *
     * The data is optional, in case it was already provided via the constructor. If it
     * is provided though, it will simply overwrite the earlier data.
     *
     * @param  array   $data      (Optional) Key=>Value list of placeholders and values
     * @param  boolean $recursive (Optional) Whether or not to process options recursively
     * @return string
     */
    public function parse(array $data = array(), $recursive = true)
    {
        $result = $this->pattern;

        if (!empty($data)) {
            $this->data = $data;
        }

        // No data means there is nothing to process
        if (empty($this->data)) {
            return $result;
        }

        foreach ($this->data as $key => $value) {
            $keyPattern = $this->edge . $key . $this->edge;
            $result = str_replace($keyPattern, $value, $result);
        }

        if (!$recursive) {
            return $result;
        }
        
        $nextResult = new Pattern($result);
        $nextResult = $nextResult->parse($this->data, false);
        
        if ($nextResult <> $result) {
            $result = (string) new Pattern($nextResult, $this->data);
        }

        return $result;
    }

    /**
     * Get placeholders
     *
     * @return array
     */
    public function getPlaceholders()
    {
        $result = array();

        if (preg_match_all('#' . $this->edge . '(.*?)' . $this->edge . '#', $this->pattern, $matches)) {
            $result = array_unique($matches[1]);
        }

        return $result;
    }

    /**
     * Render the pattern
     *
     * Note that if no data was provided via constructor, you'll get an initial pattern
     *
     * @return string
     */
    public function __toString()
    {
        return $this->parse();
    }
}
