<?php

namespace NewsletterModule\Pages\Newsletter;

use DoctrineModule\Forms\FormFactory;
use Venne\Forms\Form;

class MessageFormFactory extends FormFactory
{

	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$form->addGroup('Options');
		$form->addManyToOne('newsletter', 'Newsletter')
			->setOrderBy(array('created' => 'DESC'))
			->setPrompt(NULL);

		$form->addCheckbox('allUsers', 'Send to all')
			->addCondition($form::EQUAL, FALSE)->toggle('form-users');

		$form->addGroup()->setOption('id', 'form-users');
		$form->addManyToMany('users', 'Users');

		$form->addGroup();
		$form->addSaveButton('Odeslat newsletter');
	}

}
