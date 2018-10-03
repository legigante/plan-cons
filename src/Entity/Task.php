<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tasklist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tasklist;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="tasks")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tasktype")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_rla;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_dpgf;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_start;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_expected_end;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_recallage;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_closed;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_strat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $budget;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_prio;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $comment2;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getTasklist(): ?Tasklist
    {
        return $this->tasklist;
    }

    public function setTasklist(?Tasklist $tasklist): self
    {
        $this->tasklist = $tasklist;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getType(): ?Tasktype
    {
        return $this->type;
    }

    public function setType(?Tasktype $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateRla(): ?\DateTimeInterface
    {
        return $this->date_rla;
    }

    public function setDateRla(?\DateTimeInterface $date_rla): self
    {
        $this->date_rla = $date_rla;

        return $this;
    }

    public function getDateDpgf(): ?\DateTimeInterface
    {
        return $this->date_dpgf;
    }

    public function setDateDpgf(?\DateTimeInterface $date_dpgf): self
    {
        $this->date_dpgf = $date_dpgf;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(?\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateExpectedEnd(): ?\DateTimeInterface
    {
        return $this->date_expected_end;
    }

    public function setDateExpectedEnd(?\DateTimeInterface $date_expected_end): self
    {
        $this->date_expected_end = $date_expected_end;

        return $this;
    }

    public function getDateRecallage(): ?\DateTimeInterface
    {
        return $this->date_recallage;
    }

    public function setDateRecallage(?\DateTimeInterface $date_recallage): self
    {
        $this->date_recallage = $date_recallage;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getIsClosed(): ?bool
    {
        return $this->is_closed;
    }

    public function setIsClosed(bool $is_closed): self
    {
        $this->is_closed = $is_closed;

        return $this;
    }

    public function getDateStrat(): ?\DateTimeInterface
    {
        return $this->date_strat;
    }

    public function setDateStrat(?\DateTimeInterface $date_strat): self
    {
        $this->date_strat = $date_strat;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getIsPrio(): ?bool
    {
        return $this->is_prio;
    }

    public function setIsPrio(bool $is_prio): self
    {
        $this->is_prio = $is_prio;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getComment2(): ?string
    {
        return $this->comment2;
    }

    public function setComment2(?string $comment2): self
    {
        $this->comment2 = $comment2;

        return $this;
    }
}
