<?php

namespace TDW\ACiencia\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'asociacion')]
class Asociacion extends Element implements WebElementInterface
{
    #[ORM\ManyToMany(targetEntity: Entity::class, inversedBy: 'asociaciones')]
    #[ORM\JoinTable(name: 'asociacion_entidades')]
    private Collection $entidades;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    public function __construct(
        string $name,
        string $url,
        ?\DateTime $birthDate = null,
        ?\DateTime $deathDate = null,
        ?string $imageUrl = null,
        ?string $wikiUrl = null,
    ) {
        parent::__construct($name, $birthDate, $deathDate, $imageUrl, $wikiUrl);
        $this->url = $url;
        $this->entidades = new ArrayCollection();
    }
    public function getEntidades(): Collection
    {
        return $this->entidades;
    }

    public function getWebUrl(): ?string
    {
        return $this->url;
    }

    public function setWebUrl(?string $url): void
    {
        $this->url = $url ?? 'https://url-defecto.org';
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

    #[\JetBrains\PhpStorm\ArrayShape(['asociacion' => "array|mixed"])]
    public function jsonSerialize(): mixed
    {
        $data = parent::jsonSerialize();
        $data['url'] = $this->getWebUrl();
        $data['entidades'] = $this->getCodes($this->entidades);

        return ['asociacion' => $data];
    }
}
