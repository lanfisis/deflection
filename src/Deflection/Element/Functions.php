<?php
/**
 * Function model
 *
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection\Element;

class Functions
    extends Structure
{
    /**
     * If is static
     *
     * @var boolean
     */
    protected $is_static = false;

    /**
     * If is public
     *
     * @var boolean
     */
    protected $is_public = false;

    /**
     * Function params
     *
     * @var array
     */
    protected $params = array();

    /**
     * Is an public class
     *
     * @return \Deflection\Element\Functions
     */
    public function isPublic($status = null)
    {
        $this->is_public = $status !== null ? $status : $this->is_public;
        return $this->is_public ;
    }

    /**
     * Is an static class
     *
     * @return \Deflection\Element\Functions
     */
    public function isStatic($status = null)
    {
        $this->is_static = $status !== null ? $status : $this->is_static;
        return $this->is_static ;
    }

    /**
     * Add inteface
     *
     * @param string $name Param name
     *
     * @return \Deflection\Element\Functions
     */
    public function addParam($name, $type = null)
    {
        $this->params[(string)$name] = $type;
        return $this;
    }

    /**
     * Returns params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Generate docblock
     *
     * @return array
     */
    public function getElement()
    {
        if ($this->getDocblock()) {
            $this->setLines($this->getDocblock()->getElement());
        }
        $name = '';
        if ($this->getName()) {
            $name = ($this->isPublic() ? 'public ' : '').
                ($this->isStatic() ? 'static ' : '').
                'function '.$this->getName();
        }

        $params = array();
        foreach ($this->getParams() as $param => $type) {
            $params[] = ($type?$type.' ':'').'$'.$param;
        }
        $this->addLine($name.'('.implode(', ', $params).')');

        $this->startBlock();
        $this->addLine($this->getContent());
        $this->endBlock();
        return $this->getLines();
    }
}
