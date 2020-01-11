<?php


namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class CategorieRepository extends EntityRepository
{

    public function findByUser($id_user)
    {
        return $this->createQueryBuilder('folder')
            ->andWhere('folder.user_id = :id_user')
            ->setParameter('id_user', $id_user)
            ->getQuery()
            ->getResult();
    }
}
