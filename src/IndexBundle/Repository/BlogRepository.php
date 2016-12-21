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
     * return Query
     */
    public function getCount() {
        $query = $this->getEntityManager()
            ->createQuery('
            SELECT COUNT(*) AS total
            FROM blog_html
            ');
      //  $this->totalBlogNumber = $query['total'];
        return $query;
    }

    public function getBlog($start, $end) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT * FROM blog_html
                WHERE post_status = :post_status
                ORDER by post_date  DESC
                LIMIT :start, :end
            ')
            ->setParameters([
                'start' => $start,
                'end' => $end,
                'post_status' => 'publish'
            ]);

        return $query;
    }

    private function getLastBlog() {
        if($this->totalBlogNumber <= 0) {
            $this->getLastBlog();
        }

        $query = $this->getEntityManager()
            ->createQuery('
                SELECT * 
                FROM blog_html 
                WHERE blog_id = :blog_id
            ')
            ->setParameter(
                'blog_id', $this->totalBlogNumber
            );

        return $query;
    }
}