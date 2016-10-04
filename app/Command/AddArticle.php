<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Moulino\Framework\Model\ModelInterface;
use Moulino\Framework\Validation\ValidatorInterface;

class AddArticle extends Command
{	
	private $model;
	private $validator;

	public function __construct(ModelInterface $model, ValidatorInterface $validator) {
		$this->model = $model;
		$this->validator = $validator;
		parent::__construct();
	}

	protected function configure(){
		$this->setName('app:article-add')
			->setDescription('Add an article.')
			->addArgument('label', InputArgument::REQUIRED, 'Title for the article')
			->addArgument('content', InputArgument::OPTIONAL, 'Content of the article');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$label = $input->getArgument('label');
		$content = $input->getArgument('content');
		$parameters = [
			'label' => $label,
			'content' => $content
		];

		$violationList = $this->validator->validate($this->model, $parameters);

		if(true === $violationList->isEmpty()) {
			$this->model->add($parameters);
			$output->writeln("<info>The article with the label '$label' has been created.</info>");
		} else {
			foreach ($violationList->toArray() as $field => $violation) {
				$message = $violation[0];
				$output->writeln("<error>Validation error => $field : $message</error>");
			}
		}
	}
}

?>