A library to generate php class for file or display

How it works
============

There's two different ways to use this library:
- use element model to build your final class
- use an array and the Transformer model

The model style way
-------------------
Soon

The array style way
-------------------
```php
$transformer = new Deflection\Transformer();
$class = $transformer->arrayToClassElement(array(
    'docblock' => array(
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        'infos'       => array (
            'category'  => 'Deflection',
            'author'    => 'David Buros <david.buros@gmail.com>',
            'copyright' => '2014 David Buros',
            'licence'   => 'WTFPL see LICENCE.md file',
        ),
    ),
   'namespace' => 'Deflection',
   'uses'      => array (
       'Deflection\Element\Classes',
       'Deflection\Element\Docblock',
       'Method' => 'Deflection\Element\Functions',
    ),
    'name'       => 'Generator',
    'extends'    => 'GeneratorAbstract',
    'implements' => array(
        'ExtractorInterface',
        'LimitIterator',
    ),
    'functions' => array(
        array(
            'public'  => true,
            'name'    => 'arrayToClassElement',
            'docblock' => array(
                'description' => 'Lorem ipsum dolor sit amet',
                'params'      => array (
                    'definition' => array(
                        'type'        => 'array',
                        'description' => 'Lorem ipsum',
                    ),
                    'is_active' => array(
                        'type'        => 'boolean',
                        'description' => 'Lorem ipsum',
                    ),
                ),
                'return' => 'Deflection/Element/Functions',
            ),
            'params' => array(
                'definition' => 'array',
                'is_active'  => null,

            ),
            'content' => array(
                'if (1 == 1) {',
                array('return new Method();'),
                '}',
            ),
        ),
    ),
));

$generator = new Deflection\Generator($class);
echo($generator->asString());
```

The result
----------
```php
/**
 * Lorem ipsum dolor sit amet, consectetur adipiscing elit
 * 
 * @category  Deflection
 * @author    David Buros <david.buros@gmail.com>
 * @copyright 2014 David Buros
 * @licence   WTFPL see LICENCE.md file
 */

namespace Deflection;

use Deflection\Element\Classes;
use Deflection\Element\Docblock;
use Deflection\Element\Functions as Method;

class Generator
    extends GeneratorAbstract
    implements ExtractorInterface, LimitIterator
{
    
    /**
     * Lorem ipsum dolor sit amet
     * 
     * @var array   $definition Lorem ipsum
     * @var boolean $is_active  Lorem ipsum
     * 
     * @return Deflection/Element/Functions
     */
    public function arrayToClassElement(array $definition, $is_active)
    {
        if (1 == 1) {
            return new Method();
        }
    }
}
```

Licence
=======
DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
Read term on LICENCE.md file