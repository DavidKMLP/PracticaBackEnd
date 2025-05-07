<?php

namespace TDW\ACiencia\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use TDW\ACiencia\Entity\Entity;

#[ORM\Entity]
#[ORM\Table(name: 'asociacion')]
class Asociacion implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nombre;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\ManyToMany(targetEntity: 'TDW\ACiencia\Entity\Entity', inversedBy: 'asociaciones')]
    #[ORM\JoinTable(name: 'asociacion_entidades')]
    private Collection $entidades;

    public function __construct()
    {
        $this->entidades = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getEntidades(): Collection
    {
        return $this->entidades;
    }

    public function addEntidad(Entity $entidad): void
    {
        if (!$this->entidades->contains($entidad)) {
            $this->entidades->add($entidad);
        }
    }

    public function removeEntidad(Entity $entidad): void
    {
        $this->entidades->removeElement($entidad);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'url' => $this->getUrl(),
            'entidades' => $this->getEntidades()->map(
                fn(Entity $e) => $e->getId()
            )->toArray()
        ];
    }
}
