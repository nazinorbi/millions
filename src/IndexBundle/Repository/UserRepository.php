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

        return $this->fech_Obj('user', $query->getResult(Query::HYDRATE_ARRAY));
    }

    public function failedLogin($userName) {

        $query = $this->getEntityManager()
            ->createQuery('
                UPDATE user
                SET userFailedLogins = userFailedLogins+1,
                    userLastFailedLogin = :userLastFailedLogin
                WHERE userName = :userName
            ')
            ->setParameters(['userName' => $userName,
                             'userLastFailedLogin' => time()  ]);
        return $query->getResult(Query::HYDRATE_OBJECT);
    }

    public function succesLogin($userId) {

        $this->getEntityManager()
            ->createQuery('
                UPDATE user
                SET userFailedLogins = 0, 
                    userLastFailedLogin = NULL
                WHERE userId = :userId
            ')
            ->setParameter('userId', $userId);
    }

}