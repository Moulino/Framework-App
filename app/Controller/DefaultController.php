<?php

namespace App\Controller;
	
use Moulino\Framework\Controller\AbstractController as BaseController;
use Moulino\Framework\Config\Config;
	
class DefaultController extends BaseController
{
	public function indexAction() {
		$userModel = $this->getModel('User');
		$users = $userModel->cget();

		return $this->render('Default:index', array(
			'users' => $users
		));
	}
}

?>