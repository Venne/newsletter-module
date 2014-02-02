<?php

namespace NewsletterModule\Pages\Newsletter;

use BlogModule\Pages\Blog\AbstractTableControl;

class NewsletterTableControl extends AbstractTableControl
{

	/** @var NewsletterRepository */
	protected $routeRepository;

	/** @var NewsletterFormFactory */
	protected $formFactory;


	/**
	 * @param NewsletterRepository $routeRepository
	 * @param NewsletterFormFactory $formFactory
	 */
	public function __construct(NewsletterRepository $routeRepository, NewsletterFormFactory $formFactory)
	{
		parent::__construct();

		$this->routeRepository = $routeRepository;
		$this->formFactory = $formFactory;
	}


	protected function getRepository()
	{
		return $this->routeRepository;
	}


	protected function getFormFactory()
	{
		return $this->formFactory;
	}

}
