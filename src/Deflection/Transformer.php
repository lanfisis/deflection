<?php
/**
 * Transformer
 *
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection;

use Deflection\Element\Classes;
use Deflection\Element\Docblock;
use Deflection\Element\Functions;

class Transformer
{
    /**
     * Transform an array to a class element object
     *
     * @param array $definition Class definitoion
     *
     * @return Deflection\Element\Classes
     */
    public function arrayToClassElement($definition)
    {
        $class = new Classes();
        if (isset($definition['docblock'])) {
            $docblock = $this->arrayToDocblockElement($definition['docblock']);
            $class->setDocbloc($docblock);
        }
        if (isset($definition['namespace'])) {
            $class->setNamespace($definition['namespace']);
        }
        if (isset($definition['name'])) {
            $class->setName($definition['name']);
        }
        if (isset($definition['extends'])) {
           $class->setExtends($definition['extends']);
        }
        if (isset($definition['implements'])) {
            foreach ($definition['implements'] as $interface) {
                $class->addImplements($interface);
            }
        }
        if (isset($definition['uses'])) {
            foreach ($definition['uses'] as $alias => $use) {
                $alias = is_string($alias) ? $alias : null;
                $class->addUse($use, $alias);
            }
        }
        if (isset($definition['functions'])) {
            foreach ($definition['functions'] as $definition) {
                $function = $this->arrayToFunctionElement($definition);
                $class->addFunction($function);
            }
        }
        return $class;
    }

    /**
     * Returns well formated header with descriptions, param, return, ...
     *
     * @param array $definition Header definition
     *
     * @return Deflection\Element\Docblock
     */
    public function arrayToDocblockElement(array $definition)
    {
        $docblock = new Docblock();
        if (isset($definition['description'])) {
            $docblock->setDescription($definition['description']);
        }
        if (isset($definition['params'])) {
            foreach ($definition['params'] as $param => $infos) {
                $type = isset($infos['type']) ? $infos['type']: '';
                $description = isset($infos['description']) ? $infos['description'] : '';
                $docblock->addVar($param, $type, $description);
            }
        }
        if (isset($definition['return'])) {
            $docblock->addParam('return', $definition['return']);
        }
        if (isset($definition['infos'])) {
            foreach ($definition['infos'] as $name => $value) {
                $docblock->addParam($name, $value);
            }
        }
        return $docblock;
    }

    /**
     * Returns well formated function declaration
     *
     * @param array $definition Functions definition
     *
     * @return Deflection\Element\Functions
     */
    public function arrayToFunctionElement(array $definition)
    {
        $function = new Functions;
        if (isset($definition['docblock'])) {
            $docblock = $this->arrayToDocblockElement($definition['docblock']);
            $function->setDocbloc($docblock);
        }
        if (isset($definition['public'])) {
            $function->isPublic(true);
        }
        if (isset($definition['name'])) {
            $function->setName($definition['name']);
        }
        if (isset($definition['params'])) {
            foreach ($definition['params'] as $name => $type) {
                $function->addParam($name, $type);
            }
        }
        if (isset($definition['content'])) {
            $function->setContent($definition['content']);
        }
        return $function;
    }
}