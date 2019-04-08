<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctrinePoolRepository")
 */
class Pool
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Championship", inversedBy="pools")
     * @ORM\JoinColumn(nullable=false)
     */
    private $championship;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChampionshipTeam", mappedBy="pool", cascade={"persist", "remove"})
     */
    private $championshipTeams;

    public function __construct(string $name, Championship $championship)
    {
        $this->name = $name;
        $this->championship = $championship;

        $this->championshipTeams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getChampionship(): ?Championship
    {
        return $this->championship;
    }

    /**
     * @return Collection|ChampionshipTeam[]
     */
    public function getChampionshipTeams(): Collection
    {
        return $this->championshipTeams;
    }

    public function addChampionshipTeam(Team $team): void
    {
        $championshipTeam = new ChampionshipTeam(0, $team, $this);
        if (!$this->championshipTeams->contains($championshipTeam)) {
            $this->championshipTeams[] = $championshipTeam;
        }
    }

    public function removeChampionshipTeam(ChampionshipTeam $championshipTeam): self
    {
        if ($this->championshipTeams->contains($championshipTeam)) {
            $this->championshipTeams->removeElement( $championshipTeam );
        }

        return $this;
    }
}
