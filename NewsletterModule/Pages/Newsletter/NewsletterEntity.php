<?php

namespace NewsletterModule\Pages\Newsletter;

use BlogModule\Pages\Blog\AbstractArticleEntity;
use BlogModule\Pages\Blog\ArticleEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;
use NewsletterModule\Pages\EditableEntityTrait;
use NewsletterModule\Pages\Events\EventEntity;

/**
 * @ORM\Entity(repositoryClass="\NewsletterModule\Pages\Newsletter\NewsletterRepository")
 * @ORM\Table(name="newsletter_newsletter")
 */
class NewsletterEntity extends AbstractArticleEntity
{

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $subject = 'Newsletter navstivtevranovsko.cz';

	/**
	 * @var BoxEntity[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="BoxEntity", mappedBy="newsletter", cascade={"persist"})
	 */
	protected $boxes;

	/**
	 * @var ArticleEntity[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="\BlogModule\Pages\Blog\ArticleEntity")
	 */
	protected $blogs;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $created;

	/**
	 * @var AbstractCategoryEntity[]
	 * @ORM\ManyToMany(targetEntity="::dynamic", cascade={"persist"})
	 * @ORM\JoinTable(name="newsletter_newsletter_has_category",
	 *      joinColumns={@ORM\JoinColumn(name="articleentity_id", referencedColumnName="id", onDelete="CASCADE")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="categoryentity_id", referencedColumnName="id", onDelete="CASCADE")}
	 *      )
	 */
	protected $categories;


	public function startup()
	{
		parent::startup();

		$this->boxes = new ArrayCollection;
		$this->events = new ArrayCollection;
		$this->blogs = new ArrayCollection;
		$this->created = new \DateTime;
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getRoute()->getName() . ' (' . $this->created->format('m.d.Y H:i:s') . ')';
	}


	/**
	 * @param string $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->getRoute()
			->setName($name)
			->setTitle($name)
			->setLocalUrl(Strings::webalize($this->created->format('m.d.Y H:i:s') . '-' . $name));

		return $this;
	}


	/**
	 * @param \BlogModule\Pages\Blog\ArticleEntity[]|\Doctrine\Common\Collections\ArrayCollection $blogs
	 */
	public function setBlogs($blogs)
	{
		$this->blogs = $blogs;
	}


	/**
	 * @return \BlogModule\Pages\Blog\ArticleEntity[]|\Doctrine\Common\Collections\ArrayCollection
	 */
	public function getBlogs()
	{
		return $this->blogs;
	}


	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection|\NewsletterModule\Pages\Newsletter\BoxEntity[] $boxes
	 */
	public function setBoxes($boxes)
	{
		$this->boxes = $boxes;
	}


	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection|\NewsletterModule\Pages\Newsletter\BoxEntity[]
	 */
	public function getBoxes()
	{
		return $this->boxes;
	}


	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection|\NewsletterModule\Pages\Events\EventEntity[] $events
	 */
	public function setEvents($events)
	{
		$this->events = $events;
	}


	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection|\NewsletterModule\Pages\Events\EventEntity[]
	 */
	public function getEvents()
	{
		return $this->events;
	}


	/**
	 * @param string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;

		$this->setName($subject);
	}


	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

}
