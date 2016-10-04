<?php 

return array(

	'command_loader' => array(
		'class' => 'App\\Command\\CommandLoader',
		'arguments' => array("@container")
	),

	'article_handler' => array(
		'class' => 'App\\Service\\ArticleHandler',
		'arguments' => array("@articles_model", "@translator")
	),
	
	'password_generator' => array(
		'class' => 'App\\Service\\PasswordGenerator'
	)
);

?>