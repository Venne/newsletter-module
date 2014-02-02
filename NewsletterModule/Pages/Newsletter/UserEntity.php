<?php

namespace NewsletterModule\Pages\Newsletter;

use Doctrine\ORM\Mapping as ORM;
use DoctrineModule\Entities\IdentifiedEntity;
use Nette\InvalidArgumentException;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

/**
 * @ORM\Entity(repositoryClass="\NewsletterModule\Pages\Newsletter\UserRepository")
 * @ORM\Table(name="vranovsko_newsletter_user")
 */
class UserEntity extends IdentifiedEntity
{

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $email = '';

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $userKey;


	/**
	 * @param null|string $email
	 */
	public function __construct($email = NULL)
	{
		$this->setEmail($email);
		$this->userKey = Strings::random(30);
	}


	/**
	 * @return string
	 */
	public function getUserKey()
	{
		return $this->userKey;
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->email;
	}


	/**
	 * @param $email
	 * @throws \Nette\InvalidArgumentException
	 */
	public function setEmail($email)
	{
		if (!Validators::isEmail($email)) {
			throw new InvalidArgumentException("Email must be in correct format.");
		}

		$this->email = $email;
	}


	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

}
