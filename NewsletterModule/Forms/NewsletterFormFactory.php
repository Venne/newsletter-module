<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace NewsletterModule\Forms;

use DoctrineModule\Forms\FormFactory;
use Venne\Forms\Form;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class NewsletterFormFactory extends FormFactory
{

	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$form->addManyToOne('from', 'From');
		$form->addText('subject', 'Subject')
			->getControlPrototype()->attrs['class'] = 'input-xxlarge';
		$form->addTextArea('message', 'Message')
			->getControlPrototype()->attrs['class'] = 'input-block-level';
		$form->addManyToMany('roles', 'Roles');

		$form->addSaveButton('Save');
	}


	public function handleCatchError(Form $form, \DoctrineModule\SqlException $e)
	{
		$m = explode("'", $e->getMessage());
		$form->addError("Duplicate entry '{$m[1]}'");
		return true;
	}


	public function handleSuccess(Form $form)
	{
		$form->getPresenter()->flashMessage('Language has been saved', 'success');
	}
}
