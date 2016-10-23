<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2016. 09. 13.
 * Time: 15:38
 */

namespace IndexBundle\Libs;
use Doctrine\ORM\EntityRepository;

abstract class AbsFetch extends EntityRepository
{

    public function fech_Obj($fetchName, array $array) {
        $obj = new \stdClass();
        $obj->$fetchName = new \stdClass();

        foreach ($array[0] as $key => $value) {
            $obj->$fetchName->$key = $value;
        }
        return $obj;
    }
}