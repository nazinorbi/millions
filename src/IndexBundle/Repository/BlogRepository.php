<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2016. 12. 13.
 * Time: 14:34
 */
namespace IndexBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;

class BlogRepository extends EntityRepository {

   private $totalBlogNumber;

  /* public function __construct()
   {
       $this->getCount();
   }*/

    /**
     * @return Query
     */
    public function getCount() {
        $query = $this->getEntityManager()
            ->createQuery('
            SELECT COUNT(b.id) as total
            FROM IndexBundle:Blog b
            WHERE b.post_status = :post_status
            ')
            ->setParameter('post_status', 'publish');

        $this->totalBlogNumber = $query->getResult(Query::HYDRATE_ARRAY)[0]['total'];
        return $this->totalBlogNumber;
    }

    public function getBlog($start, $end) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT b FROM IndexBundle:Blog b 
                WHERE b.post_status = :post_status
                ORDER by b.postDate  DESC
            ')
            ->setFirstResult($start)
            ->setMaxResults($end)
            ->setParameter('post_status', 'publish')
        ;

        $query = $query->getResult(Query::HYDRATE_OBJECT);
        return $query;
    }

    public function getLastBlog() {
        if($this->totalBlogNumber <= 0) {
            $this->getCount();
        }

        $query = $this->getEntityManager()
            ->createQuery('
                SELECT b as blog
                FROM IndexBundle:Blog b 
                WHERE b.id = :id
            ')
            ->setParameter(
                'id', $this->totalBlogNumber
            );

           $query = $query->getResult(Query::HYDRATE_OBJECT)[0]['blog'];
        //print_r($query);
        return $query;
    }

}