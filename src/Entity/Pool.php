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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="pool", cascade={"persist"})
     * @ORM\OrderBy({"homeMatch"="DESC"})
     */
    private $games;

    public function __construct(string $name, Championship $championship)
    {
        $this->name = $name;
        $this->championship = $championship;

        $this->championshipTeams = new ArrayCollection();
        $this->games = new ArrayCollection();
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

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {

            if( $game->getHomeMatch() ){
                $gamesTmp = $this->games->getValues();
                array_unshift($gamesTmp, $game);
                $this->games = new ArrayCollection($gamesTmp);
            }
            else{
                $this->games[] = $game;
            }


            $game->setPool($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getPool() === $this) {
                $game->setPool(null);
            }
        }

        return $this;
    }

    public function reinitializeGames(): void
    {

    }
}
