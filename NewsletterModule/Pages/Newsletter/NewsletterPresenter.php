<?php

namespace NewsletterModule\Pages\Newsletter;

class NewsletterPresenter extends \BlogModule\Pages\Blog\AbstractArticlePresenter
{

	/** @var UserEntity */
	private $messageUser;


	/**
	 * @param UserEntity $messageUser
	 */
	public function setMessageUser(UserEntity $messageUser = NULL)
	{
		$this->messageUser = $messageUser;
	}



	public function renderDefault()
	{
		$this->template->server = $this->getHttpRequest()->getUrl()->scheme . '://' . $this->getHttpRequest()->getUrl()->host;
		$this->template->messageUser = $this->messageUser;
	}

}