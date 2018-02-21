<?php

namespace App\Command;

class CommandLoader
{
	private $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function load() {
		return [
			new AddUser(
				$this->container->get('users_model'), 
				$this->container->get('validator'),
				$this->container->get('password_encoder')
			),
			new RemoveUser(
				$this->container->get('users_model')
			),
			new ListUser(
				$this->container->get('users_model')
			),
			new SetUserPassword(
				$this->container->get('users_model'),
				$this->container->get('password_encoder')
			),
			new UnlockUser(
				$this->container->get('users_model')
			),
			new AddArticle(
				$this->container->get('articles_model'),
				$this->container->get('validator')
			),
			new RemoveArticle(
				$this->container->get('articles_model')
			),
			new ListArticle(
				$this->container->get('articles_model')
			),
			new ClearCache()
		];
	}
}

?>