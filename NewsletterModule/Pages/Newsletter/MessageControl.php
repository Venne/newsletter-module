<?php

namespace NewsletterModule\Pages\Newsletter;

use CmsModule\Content\SectionControl;
use Venne\Forms\Form;

class MessageControl extends SectionControl
{


	/** @var MessageFormFactory */
	private $formFactory;

	/** @var NewsletterManager */
	private $newsletterManager;


	/**
	 * @param MessageFormFactory $formFactory
	 * @param NewsletterManager $newsletterManager
	 */
	public function __construct(MessageFormFactory $formFactory, NewsletterManager $newsletterManager)
	{
		parent::__construct();

		$this->formFactory = $formFactory;
		$this->newsletterManager = $newsletterManager;
	}


	protected function createComponentForm()
	{
		$control = $this->formFactory->invoke(new MessageEntity);
		$control->onSuccess[] = $this->formSuccess;
		return $control;
	}


	public function formSuccess(Form $form)
	{
		if ($form->isSubmitted() === $form->getSaveButton()) {
			$x = $this->newsletterManager->sendNewsletter($form->data);

			$this->presenter->flashMessage('Newsletter byl odeslán na ' . $x . ' kontaktů.');
			$this->redirect('this');
		}
	}


	public function render()
	{
		$this->template->render();
	}
}
