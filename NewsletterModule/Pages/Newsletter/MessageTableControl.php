<?php

namespace NewsletterModule\Pages\Newsletter;

use CmsModule\Administration\Components\AdminGrid\AdminGrid;
use CmsModule\Content\SectionControl;

class MessageTableControl extends SectionControl
{

	/** @var MessageRepository */
	protected $repository;

	/** @var MessageFormFactory */
	protected $formFactory;

	/** @var NewsletterManager */
	private $newsletterManager;


	/**
	 * @param MessageRepository $repository
	 * @param MessageFormFactory $formFactory
	 * @param NewsletterManager $newsletterManager
	 */
	public function __construct(MessageRepository $repository, MessageFormFactory $formFactory, NewsletterManager $newsletterManager)
	{
		parent::__construct();

		$this->repository = $repository;
		$this->formFactory = $formFactory;
		$this->newsletterManager = $newsletterManager;
	}


	protected function getRepository()
	{

		return $this->repository;
	}


	protected function getFormFactory()
	{
		return $this->formFactory;
	}


	protected function createComponentTable()
	{
		$repository = $this->getRepository();
		$formFactory = $this->getFormFactory();
		$adminControl = new AdminGrid($repository);

		// columns
		$table = $adminControl->getTable();
		$table->setDefaultSort(array('created' => 'DESC'));

		$table->addColumnText('subject', 'Subject')
			->setCustomRender(function($entity){
				return $entity->newsletter->subject;
			})
			->getCellPrototype()->width = '100%';

		$table->addColumnDate('created', 'Created');

		$form = $adminControl->createForm($formFactory, 'Message', NULL, \CmsModule\Components\Table\Form::TYPE_LARGE);

		// actions
		$table->addAction('send', 'Send')
			->setConfirm(function(){
				return 'Really?';
			})
			->onClick[] = $this->tableSend;

		$table->addAction('edit', 'Edit')
			->getElementPrototype()->class[] = 'ajax';

		$adminControl->connectFormWithAction($form, $table->getAction('edit'));

		$table->addAction('delete', 'Delete')
			->getElementPrototype()->class[] = 'ajax';
		$adminControl->connectActionAsDelete($table->getAction('delete'));

		return $adminControl;
	}


	public function tableSend($action, $id)
	{
		$message = $this->repository->find($id);
		$x = $this->newsletterManager->sendNewsletter($message);

		$this->presenter->flashMessage('Newsletter byl odeslán na ' . $x . ' kontaktů.');
		$this->redirect('this');
	}


	public function render()
	{
		$this->template->render();
	}
}
