<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace NewsletterModule\Presenters;

use CmsModule\Administration\Components\AdminGrid\AdminGrid;
use CmsModule\Administration\Presenters\BasePresenter;
use Grido\DataSources\Doctrine;
use Nette\Mail\Message;
use NewsletterModule\Entities\DispatchEntity;
use NewsletterModule\Forms\NewsletterFormFactory;
use NewsletterModule\Repositories\NewsletterRepository;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 *
 * @secured
 */
class NewsletterPresenter extends BasePresenter
{

	/** @var NewsletterFormFactory */
	protected $newsletterFormFactory;

	/** @var NewsletterRepository */
	protected $newsletterRepository;


	/**
	 * @param \CmsModule\Forms\NewsletterFormFactory $newsletterFormFactory
	 */
	public function injectNewsletterFormFactory(NewsletterFormFactory $newsletterFormFactory)
	{
		$this->newsletterFormFactory = $newsletterFormFactory;
	}


	/**
	 * @param \NewsletterModule\Repositories\NewsletterRepository $newsletterRepository
	 */
	public function injectNewsletterRepository(NewsletterRepository $newsletterRepository)
	{
		$this->newsletterRepository = $newsletterRepository;
	}


	/**
	 * @secured(privilege="show")
	 */
	public function actionDefault()
	{
	}


	/**
	 * @secured
	 */
	public function actionCreate()
	{
	}


	/**
	 * @secured
	 */
	public function actionEdit()
	{
	}


	/**
	 * @secured
	 */
	public function handleSend($id)
	{
		$entity = $this->newsletterRepository->find($id);

		/** @var $mail Message */
		$mail = $this->context->nette->mailFactory->invoke();
		$mail->setSubject($entity->getSubject());
		$mail->setBody($entity->getMessage());
		if ($entity->getFrom()) {
			$mail->setFrom($entity->getFrom()->getEmail());

			foreach ($entity->getRoles() as $role) {
				foreach ($role->getUsers() as $user) {
					$mail->addBcc($user->getEmail());
				}
			}

			$entity->dispatches[] = $dispatch = new DispatchEntity($entity);
			$this->newsletterRepository->save($entity);

			$this->flashMessage('Message has been sent.', 'success');
		} else {
			$this->flashMessage('Sender does not have e-mail in.', 'warning');
		}

		if (!$this->isAjax()) {
			$this->redirect('this');
		}

		$this->invalidateControl('content');
		$this->payload->url = $this->link('this');
	}


	/**
	 * @secured
	 */
	public function actionRemove()
	{
	}


	protected function createComponentTable()
	{
		$_this = $this;
		$admin = new AdminGrid($this->newsletterRepository);

		// columns
		$table = $admin->getTable();
		$table->setModel(new Doctrine($this->newsletterRepository->createQueryBuilder('a')));

		$table->addColumn('subject', 'Subject')
			->setSortable()
			->getCellPrototype()->width = '100%';
		$table->getColumn('subject')
			->setFilter()->setSuggestion();

		$form = $admin->createForm($this->newsletterFormFactory, 'Newsletter', NULL, \CmsModule\Components\Table\Form::TYPE_LARGE);

		// Toolbar
		$toolbar = $admin->getNavbar();
		$toolbar->addSection('new', 'Create', 'file');
		$admin->connectFormWithNavbar($form, $toolbar->getSection('new'), $admin::MODE_PLACE);

		// actions
		if ($this->isAuthorized('edit')) {
			$table->addAction('edit', 'Edit')
				->getElementPrototype()->class[] = 'ajax';

			$admin->connectFormWithAction($form, $table->getAction('edit'), $admin::MODE_PLACE);
		}

		if ($this->isAuthorized('send')) {
			$table->addAction('send', 'Send')
				->setCustomHref(function ($entity) use ($_this) {
					return $this->link('send!', array($entity->id));
				});
		}

		if ($this->isAuthorized('remove')) {
			$table->addAction('delete', 'Delete')
				->getElementPrototype()->class[] = 'ajax';
			$admin->connectActionAsDelete($table->getAction('delete'));
		}

		return $admin;
	}
}
