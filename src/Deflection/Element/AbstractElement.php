<?php
/**
 * Abstract
 *
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection\Element;

abstract class AbstractElement
{
    /**
     * Element line
     *
     * @var array
     */
    protected $lines = array();

    /**
     * Returns line
     *
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Set all lines
     *
     * @param array $lines Lines
     *
     * @return \Deflection\Element\AbstractElement
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
        return $this;
    }

    /**
     * Add a line
     *
     * @param string $line Line
     *
     * @return \Deflection\Element\Structure
     */
    public function addLine($line)
    {
        $this->lines[] = $line;
        return $this;
    }
}
