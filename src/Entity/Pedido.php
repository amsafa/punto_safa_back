<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
#[ORM\Table(name: "pedido", schema: "puntosafa")]

class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "fecha", type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(name: "total", type: Types::FLOAT)]
    private ?float $total = null;

    #[ORM\Column(name: "estado", type: Types::STRING, length: 100)]
    private ?string $estado = null;

    #[ORM\Column(name: "direccion_entrega", type: Types::STRING, length: 255)]
    private ?string $direccion_entrega = null;

    #[ORM\Column (name: "id_cliente", type: Types::INTEGER)]
    private ?int $id_cliente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getDireccionEntrega(): ?string
    {
        return $this->direccion_entrega;
    }

    public function setDireccionEntrega(string $direccion_entrega): static
    {
        $this->direccion_entrega = $direccion_entrega;

        return $this;
    }

    public function getIdCliente(): ?int
    {
        return $this->id_cliente;
    }

    public function setIdCliente(int $id_cliente): static
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }
}
