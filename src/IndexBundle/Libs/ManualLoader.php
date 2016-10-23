<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2016. 10. 06.
 * Time: 16:19
 */

namespace IndexBundle\Libs;

use Symfony\Component\Yaml\Parser;

class ManualLoader
{

    public function manualLoad($instance)
    {
        $yaml = new Parser();
        return $this->convertToObject($yaml->parse( file_get_contents(__DIR__.'/../Resources/config/'.$instance.'.yml' )));
    }

    public function convertToObject($array) {
        $object = new \stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }
}