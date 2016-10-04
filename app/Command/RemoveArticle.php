<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

use Moulino\Framework\Model\ModelInterface;
use Moulino\Framework\Validation\ValidatorInterface;

class RemoveArticle extends Command
{	
	private $model;

	public function __construct(ModelInterface $model) {
		$this->model = $model;
		parent::__construct();
	}

	protected function configure() {
		$this->setName('app:article-remove')
			->setDescription('Remove one or all articles.')
			->addArgument('label', InputArgument::OPTIONAL, 'Title for the article')
			->addOption('all', null, InputOption::VALUE_NONE, 'Use this option alone for remove all articles');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		if(null != $input->getOption('all')) {
			$helper = $this->getHelper('question');
			$question = new ConfirmationQuestion('Would-you really remove all articles (y/n) ? ', false);

			if($helper->ask($input, $output, $question)) {
				$this->model->removeAll();
				$output->writeln("<info>All articles have been removed.</info>");
			}

		} else if(!empty($input->getArgument('label'))) {
			$label = $input->getArgument('label');
			$criteria = [
				'label' => $label
			];

			$rowAffected = $this->model->remove($criteria);

			if(!$rowAffected) {
				$output->writeln("<error>The article '$label' has not been found.");
			} else {
				$output->writeln("<info>The article '$label' has been removed.");
			}
		} else {
			$output->writeln("<error>You must define the article label or use the 'all' option.</error>");
		}
	}
}

?>