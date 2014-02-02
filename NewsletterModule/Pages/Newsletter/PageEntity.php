<?php

namespace NewsletterModule\Pages\Newsletter;

use BlogModule\Pages\Blog\AbstractPageEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\NewsletterModule\Pages\Newsletter\PageRepository")
 * @ORM\Table(name="vranovsko_newsletter_page")
 */
class PageEntity extends AbstractPageEntity
{

	/**
	 * @var ConditionsEntity
	 * @ORM\OneToOne(targetEntity="ConditionsEntity", cascade={"persist"})
	 */
	protected $conditions;


	protected function startup()
	{
		parent::startup();

		$this->getConditions();
	}


	/**
	 * @return ConditionsEntity
	 */
	public function getConditions()
	{
		if (!$this->conditions) {
			$this->conditions = $this->createRoute('\NewsletterModule\Pages\Newsletter\ConditionsEntity');
			$this->conditions->route->setPublished(TRUE);
			$this->conditions->name = 'Conditions';
		}

		return $this->conditions;
	}

}
