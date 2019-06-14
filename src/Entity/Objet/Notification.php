<?php

namespace App\Entity\Objet;

use App\Entity\Site\Event;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Objet\NotificationRepository")
 */
class Notification {
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
	 * @ORM\Column(type="string", length=255)
	 */
	private $reference;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Objet\Illustration", inversedBy="notifications")
	 */
	private $images;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Site\Event", inversedBy="notifications")
	 */
	private $event;

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

	public function getReference():  ? string {
		return $this->reference;
	}

	public function setReference(string $reference) : self{
		$this->reference = $reference;

		return $this;
	}

	public function getDescription():  ? string {
		return $this->description;
	}

	public function setDescription( ? string $description) : self{
		$this->description = $description;

		return $this;
	}

	public function getImages() :  ? Illustration {
		return $this->images;
	}

	public function setImages( ? Illustration $images) : self{
		$this->images = $images;

		return $this;
	}

	public function getEvent() :  ? Event {
		return $this->event;
	}

	public function setEvent( ? Event $event) : self{
		$this->event = $event;

		return $this;
	}

	public function __toString() : string {
		return $this->getReference();
	}

}
