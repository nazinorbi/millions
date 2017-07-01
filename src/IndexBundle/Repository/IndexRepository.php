<?php
namespace IndexBundle\Repository;

/**
 * Created by IntelliJ IDEA.
 * User: nazi
 * Date: 2017. 06. 19.
 * Time: 8:14
 */

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;


class IndexRepository extends EntityRepository {

    /**
     * @return Query
     */
    public function getText() {
        $value = 1;
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT b  
                FROM IndexBundle:Index b
            ');
        return $query->getResult(Query::HYDRATE_OBJECT)[0];
    }

    public function updateIndex($data) {
        $query =  $this->getEntityManager()
            ->createQuery('
                UPDATE IndexBundle:index i
                SET i.szoveg = :szoveg
                WHERE i.id = 1
            ')
            ->setParameter('szoveg', $data);

        return $query->getResult(Query::HYDRATE_OBJECT);
    }
}