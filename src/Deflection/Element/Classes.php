<?php
/**
 * Class model
 *
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection\Element;

class Classes
    extends Structure
{
    /**
     * If is abstract
     *
     * @var boolean
     */
    protected $is_abstract = false;

    /**
     * Namespace class name
     *
     * @var string
     */
    protected $namespace;

    /**
     * Class used by class
     *
     * @var array
     */
    protected $uses = array();

    /**
     * Extends class name
     *
     * @var string
     */
    protected $extends;

    /**
     * Implemented class names in array
     *
     * @var array
     */
    protected $implements = array();

    /**
     * Class functions
     *
     * @var array
     */
    protected $functions = array();

    /**
     * Class params
     *
     * @var array
     */
    protected $params = array();

    /**
     * Is an abstract class
     *
     * @return \Deflection\Element\Classes
     */
    public function isAbstract($status = null)
    {
        $this->is_abstract = $status !== null ? $status : $this->is_abstract;
        return $this->is_abstract ;
    }

    /**
     * Add a class to extend
     *
     * @param string $namespace Class namespace
     *
     * @return \Deflection\Element\Classes
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Returns namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Returns class full name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->getNamespace().'\\'.$this->getName();
    }


    /**
     * Add a class to extend
     *
     * @param string $extends Class name to extend
     *
     * @return \Deflection\Element\Classes
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;
        return $this;
    }

    /**
     * Returns extends
     *
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * Add inteface
     *
     * @param string $interface Interface name
     *
     * @return \Deflection\Element\Classes
     */
    public function addImplements($interface)
    {
        $this->implements[] = (string)$interface;
        return $this;
    }

    /**
     * Returns implements
     *
     * @return array
     */
    public function getImplements()
    {
        return $this->implements;
    }

    /**
     * Add use
     *
     * @param string      $class Class name
     * @param string|null $alias Use alias
     *
     * @return \Deflection\Element\Classes
     */
    public function addUse($class, $alias = null)
    {
        $as = $alias == null ? (int)(count($this->uses) + 1) : $alias;
        $this->uses[$as] = (string)$class;
        return $this;
    }

    /**
     * Returns uses
     *
     * @return array
     */
    public function getUse()
    {
        return $this->uses;
    }

    /**
     * Add function to structure
     *
     * @param \Deflection\Element\Param $param Param
     *
     * @return \Deflection\Element\Classes
     */
    public function addParam(\Deflection\Element\Param $param)
    {
        $element = $param->getElement();
        $this->params = array_merge($this->params, array(''), $element);
        return $this;
    }

    /**
     * Return struct params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Add param to structure
     *
     * @param \Deflection\Element\Functions $function Function
     *
     * @return \Deflection\Element\Classes
     */
    public function addFunction(\Deflection\Element\Functions $function)
    {
        $element = $function->getElement();
        $this->functions = array_merge($this->functions, array(''), $element);
        return $this;
    }

    /**
     * Return struct function
     *
     * @return array
     */
    public function getFunctions()
    {
        return $this->functions;
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
            $this->addBlankLine();
        }
        if ($this->getNamespace()) {
            $this->addLine('namespace '.$this->getNamespace().';');
            $this->addBlankLine();
        }
        if (count($this->getUse()) > 0) {
            foreach ($this->getUse() as $alias => $class) {
                $line = 'use '.$class;
                if (is_string($alias)) {
                    $line .= ' as '.$alias;
                }
                $this->addLine($line.';');
            }
            $this->addBlankLine();
        }
        if ($this->getName()) {
            $this->addLine(
                ($this->isAbstract() ? 'abstract ' : '').'class '.$this->getName()
            );
        }
        if ($this->getExtends()) {
            $this->addLine(array('extends '.$this->getExtends()));
        }
        if (count($this->getImplements()) > 0) {
            $this->addLine(array('implements '.implode(', ', $this->getImplements())));
        }
        $this->startBlock();
        $this->addLine($this->getParams());
        $this->addLine($this->getFunctions());
        $this->endBlock();
        return $this->getLines();
    }
}
