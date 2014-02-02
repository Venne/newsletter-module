<?php

namespace NewsletterModule\Pages\Newsletter;

use CmsModule\Administration\Components\AdminGrid\AdminGrid;
use CmsModule\Content\SectionControl;
use Nette\Application\Responses\TextResponse;

class UserTableControl extends SectionControl
{

	/** @var UserRepository */
	private $repository;

	/** @var UserFormFactory */
	private $formFactory;

	/** @var ImportFormFactory */
	private $importFormFactory;


	/**
	 * @param UserRepository $repository
	 * @param UserFormFactory $formFactory
	 * @param ImportFormFactory $importFormFactory
	 */
	public function __construct(UserRepository $repository, UserFormFactory $formFactory, ImportFormFactory $importFormFactory)
	{
		parent::__construct();

		$this->repository = $repository;
		$this->formFactory = $formFactory;
		$this->importFormFactory = $importFormFactory;
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

		$table->addColumnText('email', 'Name')
			->setSortable()
			->getCellPrototype()->width = '100%';
		$table->getColumn('email')
			->setFilterText()->setSuggestion();

		$form = $adminControl->createForm($formFactory, 'Uživatel', NULL, \CmsModule\Components\Table\Form::TYPE_LARGE);
		$import = $adminControl->createForm($this->importFormFactory, 'Import');

		// Toolbar
		$toolbar = $adminControl->getNavbar();
		$toolbar->addSection('new', 'Create', 'file');
		$adminControl->connectFormWithNavbar($form, $toolbar->getSection('new'));

		$toolbar->addSection('export', 'Export', 'floppy-save')
			->onClick[] = $this->exportClick;
		$toolbar->addSection('import', 'Import', 'floppy-open');
		$adminControl->connectFormWithNavbar($import, $toolbar->getSection('import'));

		// actions
		$table->addAction('edit', 'Edit')
			->getElementPrototype()->class[] = 'ajax';

		$adminControl->connectFormWithAction($form, $table->getAction('edit'));

		$table->addAction('delete', 'Delete')
			->getElementPrototype()->class[] = 'ajax';
		$adminControl->connectActionAsDelete($table->getAction('delete'));

		return $adminControl;
	}


	public function exportClick()
	{
		$this->redirect('export!');
	}


	public function handleExport()
	{
		$ret = array();

		foreach ($this->repository->findAll() as $user) {
			$ret[] = array($user->email, $user->userKey);
		}

		$out = "";
		foreach ($ret as $arr) {
			$out .= implode(',', $arr) . "\n";

		}

		header('Content-Type: application/csv, utf-8');
		header('Content-Disposition: attachment;filename="users.csv"');
		header('Cache-Control: max-age=0');

		$this->presenter->sendResponse(new TextResponse($out));
	}


	public function render()
	{
		$this->template->render();
	}
}
