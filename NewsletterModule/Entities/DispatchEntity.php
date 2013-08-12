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

use DoctrineModule\Entities\IdentifiedEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @ORM\Table(name="newsletterDispatch")
 */
class DispatchEntity extends IdentifiedEntity
{


	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $date;

	/**
	 * @var NewsletterEntity
	 * @ORM\ManyToOne(targetEntity="NewsletterEntity", inversedBy="dispatches")
	 * @ORM\JoinColumn(onDelete="CASCADE")
	 */
	protected $newsletter;


	public function __construct(NewsletterEntity $newsletter = NULL)
	{
		$this->newsletter = $newsletter;
		$this->date = new \DateTime;
	}


	/**
	 * @param \DateTime $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}


	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}


	/**
	 * @param \NewsletterModule\Entities\NewsletterEntity $newsletter
	 */
	public function setNewsletter($newsletter)
	{
		$this->newsletter = $newsletter;
	}


	/**
	 * @return \NewsletterModule\Entities\NewsletterEntity
	 */
	public function getNewsletter()
	{
		return $this->newsletter;
	}
}
