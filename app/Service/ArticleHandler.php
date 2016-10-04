<?php 

namespace App\Service;

use Moulino\Framework\Model\ModelInterface;
use Moulino\Framework\Translation\TranslatorInterface;

class ArticleHandler
{
	private $model;
	private $translator;

	public function __construct(ModelInterface $model, TranslatorInterface $translator) {
		$this->model = $model;
		$this->translator = $translator;
	}

	public function add($label, $content) {
		$this->model->add(array(
			'label'   => $label,
			'content' => $content
		));
	}

	public function set($label, $content) {
		$this->model->set(array(
			'label' => $label
		), array(
			'content' => $content
		));
	}

	public function get($label) {
		return $this->model->get(array('label' => $label));
	}

	public function all() {
		$articles = $this->model->cget();

		$data = array();
		foreach ($articles as $article) {
			$data[$article['label']] = $article['content'];
		}
		return $data;
	}
}

?>