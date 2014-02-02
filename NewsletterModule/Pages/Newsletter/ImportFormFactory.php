<?php

namespace NewsletterModule\Pages\Newsletter;

use Nette\Http\FileUpload;
use Nette\InvalidArgumentException;
use Venne\Forms\Form;
use Venne\Forms\FormFactory;

class ImportFormFactory extends FormFactory
{

	/** @var UserRepository */
	private $userRepository;


	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}


	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$form->addUpload('file', 'File')
			->addRule($form::FILLED);

		$form->addCheckbox('cleanout', 'Clean out');

		$form->addSaveButton('Save');
	}


	public function handleSave(Form $form)
	{
		$values = $form->values;

		if ($values['file']->isOk()) {
			if ($values['cleanout']) {
				foreach ($this->userRepository->findAll() as $user) {
					$this->userRepository->delete($user);
				}
			}

			/** @var FileUpload $file */
			$file = $values['file'];
			$data = file_get_contents($file->getTemporaryFile());

			foreach (explode("\n", $data) as $row) {
				if (!$row) {
					continue;
				}

				$items = explode(',', $row);

				if (!count($items)) {
					continue;
				}

				try {
					$user = new UserEntity(trim($items[0]));
				} catch (InvalidArgumentException $e) {
					$form->addError($e->getMessage());
				}

				$this->userRepository->save($user);
			}
		}
	}

}
