<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

use Moulino\Framework\Model\ModelInterface;

class ListUser extends Command
{
	private $model;

	public function __construct(ModelInterface $model) {
		$this->model = $model;
		parent::__construct();
	}

	protected function configure() {
		$this->setName('app:user-list')
			->setDescription('List the users.');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$users = $this->model->cget();

		$list = [];

		foreach ($users as $user) {
			$list[] = [$user['user_id'], $user['name'], $user['mail'], $user['roles']];
		}

		$table = new Table($output);
		$table->setHeaders(['Identifiant', 'Name', 'Mail', 'Roles'])
				->setRows($list);
		$table->render();
	}
}

?>