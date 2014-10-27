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

class Structure
    extends AbstractElement
{
    /**
     * Structure name
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var Deflection\Element\Docblock
     */
    protected $docblock;

    /**
     * Content
     *
     * @var array
     */
    protected $content = array();

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
    public function setDocbloc(Docblock $docblock)
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
     * Add content to structure
     *
     * @param string $content Content
     *
     * @return \Deflection\Element\Structure
     */
    public function addContent($content)
    {
        $this->content[] = $content;
        $this->addBlankLine();
        return $this;
    }

    /**
     * Set the whole content
     *
     * @param array $content Content
     *
     * @return \Deflection\Element\Structure
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Return struct content
     *
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add start element
     *
     * @return \Deflection\Element\Structure
     */
    public function startBlock()
    {
        $this->lines[] = '{';
        return $this;
    }

    /**
     * Add end element
     *
     * @return \Deflection\Element\Structure
     */
    public function endBlock()
    {
        $this->lines[] = '}';
        return $this;
    }

    /**
     * Add a blanckline
     *
     * @return \Deflection\Element\Structure
     */
    public function addBlankLine()
    {
        $this->lines[] = '';
        return $this;
    }
}