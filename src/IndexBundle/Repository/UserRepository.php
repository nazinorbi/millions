<?php
namespace IndexBundle\Repository;

/**
 * Created by IntelliJ IDEA.
 * User: nazi
 * Date: 2016.09.05.
 * Time: 10:
 */

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use IndexBundle\Libs\AbsFetch;

class UserRepository extends AbsFetch  {

    public function getUserFromLogin($userName) {

        /**
         * @return Query
         */
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT u
                FROM IndexBundle:User u
                WHERE u.userName = :userName
                ')
            ->setParameter('userName', $userName);

        return (object)$query->getResult(Query::HYDRATE_ARRAY)[0];
    }

    public function failedLogin($userName) {

        $query = $this->getEntityManager()
            ->createQuery('
                UPDATE IndexBundle:user u
                SET u.userFailedLogin = u.userFailedLogin+1,
                    u.userLastFailedLogin = :userLastFailedLogin
                WHERE userName = :userName
            ')
            ->setParameters(['userName' => $userName,
                             'userLastFailedLogin' => time()  ]);
        return $query->getResult(Query::HYDRATE_OBJECT);
    }

    public function succesLogin($userId) {

        $query =  $this->getEntityManager()
            ->createQuery('
                UPDATE IndexBundle:user u
                SET u.userFailedLogin = 0, 
                    u.userLastFailedLogin = NULL
                WHERE u.id = :id
            ')
            ->setParameter('id', $userId);

    return $query->getResult(Query::HYDRATE_OBJECT)[0];
    }
}