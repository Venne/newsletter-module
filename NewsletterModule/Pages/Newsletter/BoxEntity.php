<?php

namespace NewsletterModule\Pages\Newsletter;

use CmsModule\Content\Entities\DirEntity;
use CmsModule\Content\Entities\FileEntity;
use Doctrine\ORM\Mapping as ORM;
use DoctrineModule\Entities\IdentifiedEntity;
use Nette\Utils\Strings;

/**
 * @ORM\Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @ORM\Table(name="vranovsko_newsletter_box")
 */
class BoxEntity extends IdentifiedEntity
{

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $name = '';

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $text = '';

	/**
	 * @var NewsletterEntity
	 * @ORM\ManyToOne(targetEntity="NewsletterEntity", inversedBy="boxes")
	 */
	protected $newsletter;

	/**
	 * @var FileEntity
	 * @ORM\OneToOne(targetEntity="\CmsModule\Content\Entities\FileEntity", cascade={"all"}, orphanRemoval=true)
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 */
	protected $photo;


	/**
	 * @var DirEntity
	 * @ORM\OneToOne(targetEntity="\CmsModule\Content\Entities\DirEntity", cascade={"all"})
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 */
	protected $dir;


	public function __construct(NewsletterEntity $newsletter)
	{
		$this->newsletter = $newsletter;

		$this->dir = new DirEntity;
		$this->dir->setParent($this->newsletter->route->getDir());
		$this->dir->setInvisible(TRUE);
		$this->dir->setName(Strings::webalize(get_class($this)) . Strings::random());
	}


	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->text = $text;
	}


	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}


	public function setPhoto($photo)
	{
		$this->photo = $photo;

		if ($this->photo) {
			$this->photo->setParent($this->dir);
			$this->photo->setInvisible(TRUE);
		}
	}


	/**
	 * @return \CmsModule\Content\Entities\FileEntity
	 */
	public function getPhoto()
	{
		return $this->photo;
	}

}
