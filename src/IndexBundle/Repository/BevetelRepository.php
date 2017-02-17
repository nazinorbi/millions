<?php
namespace IndexBundle\Repository;

/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 02. 04.
 * Time: 10:52
 */

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;

class  BevetelRepository extends EntityRepository {

    private $query;
    /**
     * @return Query
     */
    public function getBevetel($whereStart = null, $whereEnd = null, $kat = null) {
        $start = new \DateTime($whereStart);
        $end = new \DateTime($whereEnd);

        $this->query = $this->createQueryBuilder('b')
            ->select('b.id', 'b.datum', 'b.bevetel', 'k.kateg')
            ->innerJoin('IndexBundle:Kategoria', 'k', 'WITH', 'b.katId = k.id')
            ->where('b.datum >= :start AND b.datum <= :endDate')
            ->setParameter('start', $start)
            ->setParameter('endDate', $end);

        if(!empty($kat) && !empty($this->query->getQuery()->getResult() )) {
            foreach ($kat as $i => $kateg) {
                if($i == 0 ) {
                    $this->query->andWhere('b.katId = :katId'.$i);
                    $this->query->setParameter('katId'.$i, $kateg);
                } else {
                    $this->query->orWhere('b.katId = :katId'.$i);
                    $this->query->setParameter('katId'.$i, $kateg);
                }
            }
            return $this->query->getQuery()->getResult();
        }
        else {
            return $this->query->getQuery()->getResult();
        }
    }
}