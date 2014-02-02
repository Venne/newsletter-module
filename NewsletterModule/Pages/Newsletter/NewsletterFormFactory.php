<?php

namespace NewsletterModule\Pages\Newsletter;

use DoctrineModule\Forms\FormFactory;
use Venne\Forms\Container;
use Venne\Forms\Form;

class NewsletterFormFactory extends FormFactory
{

	protected function getControlExtensions()
	{
		return array(
			new \DoctrineModule\Forms\ControlExtensions\DoctrineExtension(),
			new \CmsModule\Content\ControlExtension(),
			new \FormsModule\ControlExtensions\ControlExtension(),
			new \CmsModule\Content\Forms\ControlExtensions\ControlExtension(),
		);
	}


	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$extendedRoute = $form->data;

		$form->addGroup('Settings');
		$form->addText('subject', 'Předmět')
			->addRule($form::FILLED);

		$box = $form->addMany('boxes', function (Container $box) use ($form) {
			$box->setCurrentGroup($form->addGroup('Box'));
			$box->addText('name', 'Nadpis');
			$box->addTextArea('text', 'text');
			$box->addFileEntityInput('photo', 'Photo');

			$box->addSubmit('remove', 'Smazat box')
				->addRemoveOnClick();
		}, function() use ($extendedRoute) {
			return new BoxEntity($extendedRoute);
		});

		$box->addSubmit('add', 'Přidat box')
			->addCreateOnClick(); // metodu vytváří replicator

		$form->addGroup();
		$form->addManyToMany('events', 'Events');
		$form->addManyToMany('blogs', 'Blogs');

		$form->addSaveButton('Save');
	}
}
