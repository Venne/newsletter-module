<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace NewsletterModule\Pages\Newsletter\NewsletterElement;

use CmsModule\Content\Elements\BaseElement;
use Venne\Forms\Form;
use NewsletterModule\Pages\Newsletter\UserEntity;
use NewsletterModule\Pages\Newsletter\UserRepository;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class NewsletterElement extends BaseElement
{

	/** @var UserRepository */
	private $userRepository;

	/** @var NewsletterFormFactory */
	private $newsletterFormFactory;


	public function inject(
		NewsletterFormFactory $newsletterFormFactory,
		UserRepository $userRepository
	)
	{
		$this->newsletterFormFactory = $newsletterFormFactory;
		$this->userRepository = $userRepository;
	}


	/**
	 * @return \Venne\Forms\Form
	 */
	protected function createComponentForm()
	{
		$form = $this->newsletterFormFactory->invoke(new UserEntity);
		$form->onSuccess[] = $this->formSuccess;
		return $form;
	}


	public function formSuccess(Form $form)
	{
		$this->flashMessage('Váš e-mail byl přidán do newsletteru.');
		$this->redirect('this');
	}


	public function processForm()
	{
		$this->getPresenter()->redirect('this');
	}

}
