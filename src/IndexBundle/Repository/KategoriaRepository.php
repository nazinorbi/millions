<?php
namespace IndexBundle\Repository;

/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 02. 05.
 * Time: 11:09
 */

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class KategoriaRepository extends EntityRepository {

    public function getKat() {

        $query =  $this->getEntityManager()->createQuery('
            SELECT k
            FROM IndexBundle:Kategoria k
        ');

        return $query->getResult(Query::HYDRATE_OBJECT);
    }

    public function getLastKateg() {
        return  $this->getEntityManager()->createQuery('
            SELECT k
            FROM IndexBundle:Kategoria k
            ORDER BY k.id DESC 
           ')
            ->setMaxResults(1)
            ->getResult(Query::HYDRATE_OBJECT)[0];
    }

    public function insertKat($kat) {

        $query =  $this->getEntityManager()->createQuery('
            INSERT INTO IndexBundle:Kategoria k
            SET k.kateg = :kateg
        ')->setParameter('kateg', $kat);

       return $query->getResult();
    }

    public function deletKat($id) {
        $query =  $this->getEntityManager()->createQuery('
        ');
    }
}