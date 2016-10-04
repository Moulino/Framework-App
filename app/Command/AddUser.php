<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Moulino\Framework\Model\ModelInterface;
use Moulino\Framework\Auth\PasswordEncoderInterface;
use Moulino\Framework\Validation\ValidatorInterface;

class AddUser extends Command
{	
	private $model;
	private $validator;
	private $pwdEncoder;

	public function __construct(ModelInterface $model, ValidatorInterface $validator, PasswordEncoderInterface $pwdEncoder) {
		$this->model = $model;
		$this->validator = $validator;
		$this->pwdEncoder = $pwdEncoder;
		parent::__construct();
	}

	protected function configure() {
		$this->setName('app:user-add')
			->setDescription('Add an user.')
			->addArgument('user_id', InputArgument::REQUIRED, 'User identifiant for login')
			->addArgument('name', InputArgument::REQUIRED, 'User name')
			->addArgument('password', InputArgument::REQUIRED, 'User password for login')
			->addArgument('mail', InputArgument::REQUIRED, 'Mail adress for the user')
			->addArgument('roles', InputArgument::OPTIONAL, 'Roles array (optional)');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$parameters['name'] = $input->getArgument('name');
		$parameters['user_id'] = $input->getArgument('user_id');
		$parameters['mail'] = $input->getArgument('mail');
		$parameters['roles'] = $input->getArgument('roles');

		$clearPwd = $input->getArgument('password');
		$parameters['password'] = $this->pwdEncoder->encode($clearPwd);

		$parameters['errors'] = 0;

		$violationList = $this->validator->validate($this->model, $parameters);

		if(true === $violationList->isEmpty()) {
			$this->model->add($parameters);

			$name = $parameters['name'];
			$output->writeln("<info>User $name created.</info>");
		} else {
			foreach ($violationList->toArray() as $field => $violation) {
				$message = $violation[0];
				$output->writeln("<error>Validation error => $field : $message</error>");
			}
		}
	}
}