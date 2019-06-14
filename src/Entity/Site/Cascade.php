<?php

namespace App\Entity\Site;

use App\Entity\Objet\Illustration;
use App\Entity\Site\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Table(name="Cascad")
 * @ORM\Entity(repositoryClass="App\Repository\Site\CascadeRepository")
 */
class Cascade {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $libelle;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $presentation;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Site\Event", inversedBy="cascades")
	 */
	private $evenements;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Objet\Illustration", inversedBy="cascades")
	 */
	private $images;

	public function __construct() {
		$this->evenements = new ArrayCollection();
		$this->images = new ArrayCollection();
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

	public function getPresentation():  ? string {
		return $this->presentation;
	}

	public function setPresentation( ? string $presentation) : self{
		$this->presentation = $presentation;

		return $this;
	}

	/**
	 * @return Collection|Event[]
	 */
	public function getEvenements() : Collection {
		return $this->evenements;
	}

	public function addEvenement(Event $evenement): self {
		if (!$this->evenements->contains($evenement)) {
			$this->evenements[] = $evenement;
		}

		return $this;
	}

	public function removeEvenement(Event $evenement): self {
		if ($this->evenements->contains($evenement)) {
			$this->evenements->removeElement($evenement);
		}

		return $this;
	}

	/**
	 * @return Collection|Illustration[]
	 */
	public function getImages(): Collection {
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

	public function __toString(): string {
		return $this->getLibelle();
	}

}
