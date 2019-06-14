<?php

namespace App\Entity\Site;

use App\Entity\Objet\Illustration;
use App\Entity\Objet\Notification;
use App\Entity\Objet\Program;
use App\Entity\Site\Cascade;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Site\EventRepository")
 */
class Event {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $libelle;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $resume;

	/**
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Site\Cascade", mappedBy="evenements")
	 */
	private $cascades;

	/**
	 * @ORM\Column(type="string", length=50, nullable=true)
	 */
	private $type;

	/**
	 * @ORM\Column(type="string", length=50, nullable=true)
	 */
	private $agence;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $start;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $end;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Objet\Illustration", inversedBy="events")
	 */
	private $images;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $country;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Objet\Program", mappedBy="event")
	 */
	private $programs;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Objet\Notification", mappedBy="event")
	 */
	private $notifications;

	public function __construct() {
		$this->cascades = new ArrayCollection();
		$this->images = new ArrayCollection();
		$this->program = new ArrayCollection();
		$this->notifications = new ArrayCollection();
	}

	public function getId():  ? int {
		return $this->id;
	}

	public function getLibelle() :  ? string {
		return $this->libelle;
	}

	public function setLibelle(string $libelle) : self{
		$this->libelle = $libelle;

		return $this;
	}

	public function getResume():  ? string {
		return $this->resume;
	}

	public function setResume( ? string $resume) : self{
		$this->resume = $resume;

		return $this;
	}

	public function getDescription() :  ? string {
		return $this->description;
	}

	public function setDescription(string $description) : self{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return Collection|Cascade[]
	 */
	public function getCascades(): Collection {
		return $this->cascades;
	}

	public function addCascade(Cascade $cascade): self {
		if (!$this->cascades->contains($cascade)) {
			$this->cascades[] = $cascade;
			$cascade->addEvenement($this);
		}

		return $this;
	}

	public function removeCascade(Cascade $cascade): self {
		if ($this->cascades->contains($cascade)) {
			$this->cascades->removeElement($cascade);
			$cascade->removeEvenement($this);
		}

		return $this;
	}

	public function getType():  ? string {
		return $this->type;
	}

	public function setType( ? string $type) : self{
		$this->type = $type;

		return $this;
	}

	public function getAgence() :  ? string {
		return $this->agence;
	}

	public function setAgence( ? string $agence) : self{
		$this->agence = $agence;

		return $this;
	}

	public function getStart() :  ? \DateTimeInterface {
		return $this->start;
	}

	public function setStart( ? \DateTimeInterface $start) : self{
		$this->start = $start;

		return $this;
	}

	public function getEnd() :  ? \DateTimeInterface {
		return $this->end;
	}

	public function setEnd( ? \DateTimeInterface $end) : self{
		$this->end = $end;

		return $this;
	}

	/**
	 * @return Collection|Illustration[]
	 */
	public function getImages() : Collection {
		return $this->images;
	}

	public function addImage(Illustration $image): self {
		if (!$this->images->contains($image)) {
			$this->images[] = $image;
		}

		return $this;
	}

	public function removeImage(Illustration $image): self {
		if ($this->images->contains($image)) {
			$this->images->removeElement($image);
		}

		return $this;
	}

	public function getCountry():  ? string {
		return $this->country;
	}

	public function setCountry( ? string $country) : self{
		$this->country = $country;

		return $this;
	}

	/**
	 * @return Collection|Program[]
	 */
	public function getProgram() : Collection {
		return $this->program;
	}

	public function addProgram(Program $program): self {
		if (!$this->program->contains($program)) {
			$this->program[] = $program;
			$program->setEvent($this);
		}

		return $this;
	}

	public function removeProgram(Program $program): self {
		if ($this->program->contains($program)) {
			$this->program->removeElement($program);
			// set the owning side to null (unless already changed)
			if ($program->getEvent() === $this) {
				$program->setEvent(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Notification[]
	 */
	public function getNotifications(): Collection {
		return $this->notifications;
	}

	public function addNotification(Notification $notification): self {
		if (!$this->notifications->contains($notification)) {
			$this->notifications[] = $notification;
			$notification->setEvent($this);
		}

		return $this;
	}

	public function removeNotification(Notification $notification): self {
		if ($this->notifications->contains($notification)) {
			$this->notifications->removeElement($notification);
			// set the owning side to null (unless already changed)
			if ($notification->getEvent() === $this) {
				$notification->setEvent(null);
			}
		}

		return $this;
	}

	public function __toString(): string {
		return $this->getLibelle() . $this->getId();
	}

}
