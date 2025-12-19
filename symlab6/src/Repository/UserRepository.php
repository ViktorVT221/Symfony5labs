<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllUsersByFilter(
        array $data,
        int $itemsPerPage,
        int $page
    ): array {
        $qb = $this->createQueryBuilder('u');

        // 🔍 Фільтрація
        if (!empty($data['name'])) {
            $qb->andWhere('u.name LIKE :name')
               ->setParameter('name', '%' . $data['name'] . '%');
        }

        if (!empty($data['email'])) {
            $qb->andWhere('u.email LIKE :email')
               ->setParameter('email', '%' . $data['email'] . '%');
        }

        if (!empty($data['phone'])) {
            $qb->andWhere('u.phone LIKE :phone')
               ->setParameter('phone', '%' . $data['phone'] . '%');
        }

        // 📄 Пагінація
        $paginator = new Paginator($qb);
        $totalItems = count($paginator);
        $totalPageCount = (int)ceil($totalItems / $itemsPerPage);

        $qb->setFirstResult($itemsPerPage * ($page - 1))
           ->setMaxResults($itemsPerPage);

        return [
            'users' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPageCount,
            'totalItems' => $totalItems,
        ];
    }
}
