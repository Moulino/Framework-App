<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

use Moulino\Framework\Model\ModelInterface;

class UnlockUser extends Command
{
	private $model;

	public function __construct(ModelInterface $model) {
		$this->model = $model;
		parent::__construct();
	}

	protected function configure() {
		$this->setName('app:user-unlock')
			->setDescription('Unlock user account.')
			->addArgument('user_id', InputArgument::OPTIONAL, 'User identifiant');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$user_id = $input->getArgument('user_id');
		$this->model->set(['user_id' => $user_id], ['errors' => 0]);
		$output->writeln("<info>The user account has been unlocked.</info>");
	}
}