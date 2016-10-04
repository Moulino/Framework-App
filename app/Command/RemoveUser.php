<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

use Moulino\Framework\Model\ModelInterface;

class RemoveUser extends Command
{	
	private $model;

	public function __construct(ModelInterface $model) {
		$this->model = $model;
		parent::__construct();
	}

	protected function configure(){
		$this->setName('app:user-remove')
			->setDescription('Remove an user.')
			->addArgument('user_id', InputArgument::OPTIONAL, 'User identifiant')
			->addArgument('all', null, InputOption::VALUE_NONE, 'Use this option alone for remove all users');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

		if(null != $input->getOption('all')) {
			$helper = $this->getHelper('question');
			$question = new ConfirmationQuestion('Would-you really remove all users (y/n) ?', false);

			if($helper->ask($input, $output, $question)) {
				$this->model->removeAll();
				$output->writeln("<info>All users have been removed.</info>");
			}
		} else if(!empty($input->getArgument('label'))) {
			$user_id = $input->getArgument('user_id');

			$rowAffected = $this->model->remove(['user_id' => $user_id]);

			if(!$rowAffected) {
				$output->writeln("<error>The user '$user_id' has not been found.</error>");
			} else {
				$output->writeln("<info>The user '$user_id' has been removed.");
			}
		} else {
			$output->writeln("<error>You must define the user identifiant or use the 'all' flag for remove all users.");
		}
	}
}

?>