<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace NewsletterModule\Entities;

use CmsModule\Security\Entities\RoleEntity;
use CmsModule\Security\Entities\UserEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DoctrineModule\Entities\IdentifiedEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity(repositoryClass="\NewsletterModule\Repositories\NewsletterRepository")
 * @ORM\Table(name="newsletter")
 */
class NewsletterEntity extends IdentifiedEntity
{

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $subject = '';

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $message = '';

	/**
	 * @var RoleEntity[]
	 * @ORM\ManyToMany(targetEntity="\CmsModule\Security\Entities\RoleEntity")
	 */
	protected $roles;

	/**
	 * @var DispatchEntity[]
	 * @ORM\OneToMany(targetEntity="DispatchEntity", mappedBy="newsletter", cascade={"persist"})
	 */
	protected $dispatches;

	/**
	 * @var UserEntity
	 * @ORM\ManyToOne(targetEntity="\CmsModule\Security\Entities\UserEntity")
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 */
	protected $from;


	public function __construct()
	{
		$this->roles = new ArrayCollection;
		$this->dispatches = new ArrayCollection;
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getSubject();
	}


	/**
	 * @param string $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}


	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}


	/**
	 * @param \CmsModule\Security\Entities\RoleEntity[] $roles
	 */
	public function setRoles($roles)
	{
		$this->roles = $roles;
	}


	/**
	 * @return \CmsModule\Security\Entities\RoleEntity[]
	 */
	public function getRoles()
	{
		return $this->roles;
	}


	/**
	 * @param string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}


	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}


	/**
	 * @param $dispatches
	 */
	public function setDispatches($dispatches)
	{
		$this->dispatches = $dispatches;
	}


	/**
	 * @return DispatchEntity[]
	 */
	public function getDispatches()
	{
		return $this->dispatches;
	}


	/**
	 * @param \CmsModule\Security\Entities\UserEntity $from
	 */
	public function setFrom($from)
	{
		$this->from = $from;
	}


	/**
	 * @return \CmsModule\Security\Entities\UserEntity
	 */
	public function getFrom()
	{
		return $this->from;
	}
}
