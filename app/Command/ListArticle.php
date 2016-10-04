<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

use Moulino\Framework\Model\ModelInterface;

class ListArticle extends Command
{
	private $model;

	public function __construct(ModelInterface $model) {
		$this->model = $model;
		parent::__construct();
	}

	protected function configure() {
		$this->setName('app:article-list')
			->setDescription('List the users.');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$articles = $this->model->cget();

		$list = [];

		foreach ($articles as $article) {
			$list[] = [$article['label'], $article['content']];
		}

		$table = new Table($output);
		$table->setHeaders(['Label', 'Content'])
				->setRows($list);
		$table->render();
	}
}

?>