<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 02. 10.
 * Time: 9:55
 */

namespace IndexBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;

class TranzNumberRepository extends EntityRepository {

    private $query;

    /**
     * @return Query
     */
    public function getTranz() {

        $this->query = $this->createQueryBuilder('t')
            ->select('t')
            ->getQuery()->getResult(Query::HYDRATE_OBJECT)[0];

        return $this->query;
    }

    public function updateTranzNumber($datum, $sumTranz) {

        $query = $this->getEntityManager()
            ->createQuery('
                UPDATE IndexBundle:TranzNumber b
                SET b.sumTranz = b.sumTranz+1,
                    b.datum = :datum,
                    b.sumTranz = :sumTranz
                WHERE b.id = :id
            ')->setParameters(['id' => 1,
                               'datum' => $datum,
                               'sumTranz' => $sumTranz]);

        return $query->getResult();
    }
}