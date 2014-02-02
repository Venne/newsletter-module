<?php

namespace NewsletterModule\Pages\Newsletter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DoctrineModule\Entities\IdentifiedEntity;

/**
 * @ORM\Entity(repositoryClass="\NewsletterModule\Pages\Newsletter\MessageRepository")
 * @ORM\Table(name="vranovsko_newsletter_message")
 */
class MessageEntity extends IdentifiedEntity
{


	/**
	 * @var NewsletterEntity
	 * @ORM\ManyToOne(targetEntity="NewsletterEntity")
	 * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $newsletter;

	/**
	 * @var UserEntity[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="UserEntity")
	 */
	protected $users;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean")
	 */
	protected $allUsers = FALSE;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $created;


	public function __construct()
	{
		$this->newsletter = new ArrayCollection;
		$this->created = new \DateTime;
	}


	/**
	 * @param NewsletterEntity $newsletter
	 */
	public function setNewsletter($newsletter)
	{
		$this->newsletter = $newsletter;
	}


	/**
	 * @return NewsletterEntity
	 */
	public function getNewsletter()
	{
		return $this->newsletter;
	}


	/**
	 * @param UserEntity[]|ArrayCollection $users
	 */
	public function setUsers($users)
	{
		$this->users = $users;
	}


	/**
	 * @return UserEntity[]|ArrayCollection
	 */
	public function getUsers()
	{
		return $this->users;
	}


	/**
	 * @param boolean $allUsers
	 */
	public function setAllUsers($allUsers)
	{
		$this->allUsers = $allUsers;
	}


	/**
	 * @return boolean
	 */
	public function getAllUsers()
	{
		return $this->allUsers;
	}


	/**
	 * @param \DateTime $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}


	/**
	 * @return \DateTime
	 */
	public function getCreated()
	{
		return $this->created;
	}

}
