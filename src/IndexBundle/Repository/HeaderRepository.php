<?php

namespace IndexBundle\Repository;

/**
 * HeaderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;

class HeaderRepository extends EntityRepository
{
    /*
    /**
     * @return Query
    */
    public function getHeader($ratioMin, $ratioMax) {

        $query =  $this->getEntityManager()
            ->createQuery('
             SELECT h
             FROM IndexBundle:Header h 
             WHERE h.imageRatio >= :ratioMin 
             AND h.imageRatio <= :ratioMax         
            ')
            ->setParameters(['ratioMin' => $ratioMin,
                'ratioMax' => $ratioMax]);
        return $query->getResult(Query::HYDRATE_ARRAY);


    }
}
