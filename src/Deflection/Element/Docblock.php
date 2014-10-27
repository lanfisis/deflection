<?php
/**
 * Generator
 *
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection\Element;

class Docblock
    extends AbstractElement
{
    /**
     * Description lines
     *
     * @var array
     */
    protected $description = array();

    /**
     * All var types, var name as key
     *
     * @var array
     */
    protected $var_types = array();

    /**
     * All var description, var name as key
     *
     * @var array
     */
    protected $var_descriptions = array();

    /**
     * Params
     *
     * @var array
     */
    protected $params = array();

    /**
     * Set description at top of docblock
     *
     * @param string $text   Description
     * @param int    $length Length to split line
     *
     * @return \Deflection\Element\Docblock
     */
    public function setDescription($text, $length = 80)
    {
        $description = array();
        $split = str_split($text, $length);
        array_walk($split, function ($value) use (&$description) {
            $description[] = $value;
        });
        $this->description = $description;
        return $this;
    }

    /**
     * Add a var on a docblock
     *
     * @param string $name        Var name
     * @param string $type        Var type like string, boolean, ...
     * @param string $description Var description
     *
     * @return \Deflection\Element\Docblock
     */
    public function addVar($name, $type = '', $description = '')
    {
        $this->var_types[$name] = $type == '' ? $type : $type.' ';
        $this->var_descriptions[$name] = $description;
        return $this;
    }

    /**
     *
     * @param type $name
     * @param type $value
     *
     * @return \Deflection\Element\Docblock
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Generate docblock
     *
     * @return \Deflection\Element\Docblock
     */
    public function getElement()
    {
        $this->startCommentBlock();
        foreach ($this->description as $line) {
            $this->addLine($line);
        }
        $this->addBlankLine();

        if (count($this->var_types) > 0) {
            $type_ltgh = max(array_map('mb_strlen', $this->var_types));
            $var_ltgh = max(array_map('mb_strlen', array_keys($this->var_types)));
            foreach ($this->var_types as $name => $type) {
                $type = str_pad($type, $type_ltgh);
                $param = str_pad($name, $var_ltgh);
                $this->addLine('@var '.$type.'$'.$param.' '.$this->var_descriptions[$name]);
            }
            $this->addBlankLine();
        }

        if (count($this->params) > 0) {
            $params_ltgh = array_map('strlen', array_keys($this->params));
            foreach ($this->params as $param => $value) {
                $this->addLine('@'.str_pad($param, max($params_ltgh)).' '.$value);
            }
        }

        $this->endCommentBlock();
        return $this->lines;
    }

    /**
     * Add a docblock start element
     *
     * @return \Deflection\Element\Docblock
     */
    public function startCommentBlock()
    {
        $this->lines[] = '/**';
        return $this;
    }

    /**
     * Add a docblock end element
     *
     * @return \Deflection\Element\Docblock
     */
    public function endCommentBlock()
    {
        $this->lines[] = ' */';
        return $this;
    }

    /**
     * Add a blanckline docblock style
     *
     * @return \Deflection\Element\Docblock
     */
    public function addBlankLine()
    {
        $this->lines[] = ' * ';
        return $this;
    }

    /**
     * Add a line docblock style
     *
     * @param string $line Line
     *
     * @return \Deflection\Element\Docblock
     */
    public function addLine($line)
    {
        $this->lines[] = ' * '.$line;
        return $this;
    }
}
