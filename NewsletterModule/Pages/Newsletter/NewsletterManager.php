<?php

namespace NewsletterModule\Pages\Newsletter;

use Nette\Application\Application;
use Nette\Mail\Message;
use Nette\Object;
use NewsletterModule\MailFactory;

class NewsletterManager extends Object
{

	/** @var MailFactory */
	private $mailFactory;

	/** @var Application */
	private $application;

	/** @var UserRepository */
	private $userRepository;


//	/**
//	 * @param MailFactory $mailFactory
//	 * @param Application $application
//	 * @param UserRepository $userRepository
//	 */
//	public function __construct(MailFactory $mailFactory, Application $application, UserRepository $userRepository)
//	{
//		$this->mailFactory = $mailFactory;
//		$this->application = $application;
//		$this->userRepository = $userRepository;
//	}


	/**
	 * @param MessageEntity $messageEntity
	 * @return int
	 */
	public function sendNewsletter(MessageEntity $messageEntity)
	{
		$newsletter = $messageEntity->newsletter;
		/** @var NewsletterPresenter $presenter */
		$presenter = $this->application->getPresenterFactory()->createPresenter('Vranovsko:Pages:Newsletter:Newsletter');
		$presenter->autoCanonicalize = FALSE;

		/** @var Message $message */
		$message = $this->mailFactory->invoke();
		$message->setSubject($newsletter->getSubject());

		$x = 0;
		foreach (($messageEntity->getAllUsers() ? $this->userRepository->findAll() : $messageEntity->users) as $user) {

			$presenter->setMessageUser($user);
			$request = new \Nette\Application\Request('Vranovsko:Pages:Newsletter:Newsletter', 'GET', array('routeId' => $newsletter->route->id));
			$response = $presenter->run($request);
			$html = (string)$response->getSource();

			$userMessage = clone $message;
			$userMessage->addTo($user->email);
			$userMessage->setHtmlBody($html, FALSE);
			$userMessage->send();
			$x++;
		}

		return $x;
	}

}
