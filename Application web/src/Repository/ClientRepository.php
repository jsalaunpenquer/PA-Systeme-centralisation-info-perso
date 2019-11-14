<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ClientRepository extends EntityRepository implements  UserLoaderInterface {
    public function save(Client $user) {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function delete(Client $user) {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    public function loadUserByUsername($username) {
        $user = $this->createQueryBuilder('u')
            ->where('u.login = :login or u.adresseMailPerso = :adresseMailPerso')
            ->setParameter('login', $username)
            ->setParameter('adresseMailPerso', $username)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $user) {
            $message = print_r(
                'Unable to find an active admin App:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message);
        }
        return $user;
    }
}