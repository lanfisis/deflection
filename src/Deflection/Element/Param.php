<?php
/**
 * Structure
 *
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection\Element;

class Param
    extends AbstractElement
{
    /**
     * Structure name
     *
     * @var string
     */
    protected $name;

    /**
     * Docblock
     *
     * @var Deflection\Element\Docblock
     */
    protected $docblock;

    /**
     * Param type
     *
     * @var string
     */
    protected $type;

    /**
     * Param value
     *
     * @var string
     */
    protected $value;

    /**
     * Returns type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set type
     *
     * @param string $type Type
     *
     * @return \Deflection\Element\Param
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set value
     *
     * @param string $value Value
     *
     * @return \Deflection\Element\Param
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set param is protected
     *
     * @return \Deflection\Element\Param
     */
    public function isProtected()
    {
        $this->type = 'protected';
        return $this;
    }

    /**
     * Set param is public
     *
     * @return \Deflection\Element\Param
     */
    public function isPublic()
    {
        $this->type = 'public';
        return $this;
    }

    /**
     * Set class name
     *
     * @param string $name
     *
     * @return \Deflection\Element\Classes
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns struct name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set class docblock
     *
     * @param Deflection\Element\Docblock $docblock Docblock
     *
     * @return \Deflection\Element\Classes
     */
    public function setDocblock(Docblock $docblock)
    {
        $this->docblock = $docblock;
        return $this;
    }

    /**
     * Returns docblock
     *
     * @return Deflection\Element\Docblock
     */
    public function getDocblock()
    {
        return $this->docblock;
    }

    /**
     * Return param content
     *
     * @return array
     */
    public function getElement()
    {
        if ($this->getDocblock()) {
            $this->setLines($this->getDocblock()->getElement());
        }

        $name = '';
        if ($this->getName() and !is_array($this->getValue())) {
            $name = ($this->getType() ? $this->getType().' ' : '')
                .'$'.$this->getName().
                ($this->getValue() ? ' = '.$this->getValue() : '').';';
            $this->addLine($name);
        } else if ($this->getName() and is_array($this->getValue())) {
            $value = $this->getValue();
            $begin = array_shift($value);
            $end = array_pop($value);
            $value[] = $end.';';
            $this->addLine(($this->getType() ? $this->getType().' ' : '').'$'.$this->getName().' = '.$begin);
            $this->addLine($value);
        }


        return $this->getLines();
    }
}