<?php
/**
 * Generator
 *
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection;

use Deflection\Element\Classes;

class Generator
{
    /**
     * Class
     *
     * @var Deflection\Element\Classes
     */
    protected $class;

    /**
     * Tabulation base
     *
     * @var string
     */
    protected $tab = 4;

    /**
     * Constructor!
     *
     * @param Deflection\Element\Classes $class Class to generate
     */
    public function __construct(Classes $class)
    {
        $this->class = $class;
    }

    /**
     * Returns class definition as a string
     *
     * @return string
     */
    public function asString()
    {
        $display = function ($lines, $length, $loop = 0) use (&$display) {
            $output = '';
            foreach ($lines as $line) {
                $line = is_a($line, 'Deflection\Element\AbstractElement') ? $line->getElement() : $line;
                if (is_array($line)) {
                    $output .= $display($line, $length, $loop+1);
                } else {
                    $size = mb_strlen($line)+($length*$loop);
                    $output .= str_pad($line, $size, ' ', STR_PAD_LEFT)."\n";
                }
            }
            return $output;
        };
        return !$this->class ?: "<?php\n".$display($this->class->getElement(), $this->tab);
    }
}