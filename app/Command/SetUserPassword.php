<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Moulino\Framework\Model\ModelInterface;
use Moulino\Framework\Auth\PasswordEncoderInterface;

class SetUserPassword extends Command
{	
	private $model;
	private $pwdEncoder;

	public function __construct(ModelInterface $model, PasswordEncoderInterface $pwdEncoder){
		$this->model = $model;
		$this->pwdEncoder = $pwdEncoder;
		parent::__construct();
	}

	protected function configure(){
		$this->setName('app:user-set-password')
			->setDescription('Set the user password.')
			->addArgument('user_id', InputArgument::REQUIRED, 'User identifiant')
			->addArgument('password', InputArgument::REQUIRED, 'User password');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$user_id = $input->getArgument('user_id');
		$clear_pwd = $input->getArgument('password');

		$pwd = $this->pwdEncoder->encode($clear_pwd);

		$rowAffected = $this->model->set(['user_id' => $user_id], ['password' => $pwd]);

		if($rowAffected) {
			$output->writeln("<info>The new password for user '$user_id' has been affected.</info>");
		} else {
			$output->writeln("<error>The user '$user_id' was not found.</error>");
		}
	}

}

?>