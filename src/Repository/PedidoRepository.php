<?php

namespace App\Repository;

use App\Entity\Pedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pedido>
 */
class PedidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pedido::class);
    }


    //Alba para probar reseñas
    public function findByUsuario(int $usuarioId): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.cliente', 'c') // Unir Pedido con Cliente
            ->join('c.usuario', 'u') // Unir Cliente con Usuario
            ->andWhere('u.id = :usuarioId') // Filtrar por el ID del usuario
            ->setParameter('usuarioId', $usuarioId)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Pedido[] Returns an array of Pedido objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pedido
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
