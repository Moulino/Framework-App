<?php

namespace App\Twig\Extension;

class ArticleLoaderExtension extends \Twig_Extension
{
	private $articleHandler;
	private $locale;

	public function __construct($articleHandler, $locale) {
		$this->articleHandler = $articleHandler;
		$this->locale = $locale;
	}

	public function getFunctions() {
		return array(
			new \Twig_SimpleFunction('article', array($this, 'getArticle'))
		);
	}

	public function getArticle($label) {
		$article = $this->articleHandler->get($label);

		if(array_key_exists('content_'.$this->locale, $article)) {
			return $article['content_'.$this->locale];
		}
	}

	public function getName() {
		return 'article_loader';
	}
}