<?php
namespace IndexBundle\Repository;

/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 02. 04.
 * Time: 20:39
 */



use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;


class ZarasRepository extends EntityRepository {

    /**
     * @return Query
     */
    public function getZaras() {

        return $this->getEntityManager()->createQuery('
            SELECT z
            FROM IndexBundle:Zaras z
            ORDER BY z.id DESC
        ')
            ->setMaxResults(1)
            ->getResult(Query::HYDRATE_OBJECT)[0];
    }

    public function getBeatwinZaras($whereStart, $whereEnd) {
        $start = new \DateTime($whereStart);
        $end = new \DateTime($whereEnd);

        $query = $this->getEntityManager()->createQuery('
            SELECT z.osszeg, z.datum
            FROM IndexBundle:Zaras z
            WHERE z.datum >= :start AND z.datum <= :endDate
            ORDER BY z.datum DESC 
        ')
            ->setParameter('start', $start)
            ->setParameter('endDate', $end)
            ->setMaxResults(1);

       $result = $query->getResult(Query::HYDRATE_OBJECT);
        if(!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function updateZaras($id, $aktEgy, $date) {

        $query = $this->getEntityManager()
            ->createQuery('
                UPDATE IndexBundle:Zaras z
                SET z.osszeg = :osszeg,
                    z.datum = :datum
                WHERE z.id = :id
            ')->setParameters(['id' => $id,
                               'osszeg' => $aktEgy,
                               'datum' => $date]
            );

        return $query->getResult();
    }
}