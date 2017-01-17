<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 01. 02.
 * Time: 20:26
 */

namespace IndexBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;

class BlogLabelsRepository extends EntityRepository {

    public  function getTitle($id) {
        $query = $this->getEntityManager()
            ->createQuery('
            SELECT b.name
            FROM IndexBundle:blogLabels b
            WHERE b.id = :id')
            ->setParameter('id', $id);

        return $query->getResult()[0]['name'];
    }
}