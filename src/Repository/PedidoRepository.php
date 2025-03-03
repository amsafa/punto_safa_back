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

    public function totalPedidosByCliente($clienteId)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->Where('p.cliente = :clienteId')
            ->setParameter('clienteId', $clienteId)
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function deliveredPedidosByCliente($clienteId)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->Where('p.cliente = :clienteId')
            ->andWhere('p.estado = :estado')
            ->setParameter('clienteId', $clienteId)
            ->setParameter('estado', 'entregado')
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function processedPedidosByCliente($clienteId)
    {

        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->Where('p.cliente = :clienteId')
            ->andWhere('p.estado = :estado')
            ->setParameter('clienteId', $clienteId)
            ->setParameter('estado', 'procesado')
            ->getQuery()
            ->getSingleScalarResult();

    }


}
