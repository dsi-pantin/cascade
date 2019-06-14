<?php

namespace App\Entity\Objet;

use App\Entity\Site\Cascade;
use App\Entity\Site\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Objet\IllustrationRepository")
 * @Vich\Uploadable
 */
class Illustration {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $image;

	/**
	 * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
	 * @var File
	 */
	private $imageFile;

	/**
	 * @ORM\Column(type="datetime")
	 * @var \DateTime
	 */
	private $updatedAt;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Site\Event", mappedBy="images")
	 */
	private $events;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Site\Cascade", mappedBy="images")
	 */
	private $cascades;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Objet\Notification", mappedBy="images")
	 */
	private $notifications;

	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Objet\Program", mappedBy="image", cascade={"persist", "remove"})
	 */
	private $program;

	public function __construct() {
		$this->events = new ArrayCollection();
		$this->cascades = new ArrayCollection();
		$this->notifications = new ArrayCollection();
	}

	public function getId():  ? int {
		return $this->id;
	}

	public function getImage() :  ? string {
		return $this->image;
	}

	public function setImage(string $image) : self{
		$this->image = $image;

		return $this;
	}

	public function getImageFile() {
		return $this->imageFile;
	}

	public function setImageFile(File $imageFile = null) {
		$this->imageFile = $imageFile;

		if ($imageFile) {
			$this->updatedAt = new \DateTime('now');
		}

		return $this;
	}

	public function getUpdatedAt():  ? \DateTimeInterface {
		return $this->updatedAt;
	}

	public function setUpdatedAt(\DateTimeInterface $updatedAt) : self{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * @return Collection|Event[]
	 */
	public function getEvents(): Collection {
		return $this->events;
	}

	public function addEvent(Event $event): self {
		if (!$this->events->contains($event)) {
			$this->events[] = $event;
			$event->addImage($this);
		}

		return $this;
	}

	public function removeEvent(Event $event): self {
		if ($this->events->contains($event)) {
			$this->events->removeElement($event);
			$event->removeImage($this);
		}

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
			$cascade->addImage($this);
		}

		return $this;
	}

	public function removeCascade(Cascade $cascade): self {
		if ($this->cascades->contains($cascade)) {
			$this->cascades->removeElement($cascade);
			$cascade->removeImage($this);
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
			$notification->setImages($this);
		}

		return $this;
	}

	public function removeNotification(Notification $notification): self {
		if ($this->notifications->contains($notification)) {
			$this->notifications->removeElement($notification);
			// set the owning side to null (unless already changed)
			if ($notification->getImages() === $this) {
				$notification->setImages(null);
			}
		}

		return $this;
	}

	public function getProgram():  ? Program {
		return $this->program;
	}

	public function setProgram( ? Program $program) : self{
		$this->program = $program;

		// set (or unset) the owning side of the relation if necessary
		$newImage = $program === null ? null : $this;
		if ($newImage !== $program->getImage()) {
			$program->setImage($newImage);
		}

		return $this;
	}

	public function __toString() : string {
		return $this->getImage();
	}

}
