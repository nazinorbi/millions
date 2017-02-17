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

class KuszobRepository extends EntityRepository {

    /**
     * @return Query
     */
    public function getKuszob() {

        $query =  $this->getEntityManager()->createQuery('
            SELECT k
            FROM IndexBundle:Kuszob k
            WHERE k.id = :id
        ')
            ->setParameter('id', 1);

        return $query->getResult(Query::HYDRATE_OBJECT)[0]->kuszob;
    }

    public function updateKuszob($kuszob) {

        $query = $this->getEntityManager()
            ->createQuery('
                UPDATE IndexBundle:Kuszob k
                SET k.kuszob = :kuszob
                WHERE k.id = :id
            ')->setParameters(['id' => 1,
                                'kuszob' => $kuszob]
            );

        return $query->getResult();
    }
}