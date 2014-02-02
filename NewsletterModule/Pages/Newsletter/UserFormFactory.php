<?php

namespace NewsletterModule\Pages\Newsletter;

use DoctrineModule\Forms\FormFactory;
use Venne\Forms\Form;

class UserFormFactory extends FormFactory
{

	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$form->addText('email', 'E-mail')
			->addRule($form::FILLED)
			->addRule($form::EMAIL);

		$form->addSaveButton('Save');
	}

}
