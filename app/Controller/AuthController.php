<?php 

namespace App\Controller;

use Moulino\Framework\Controller\AbstractController as BaseController;
use Moulino\Framework\Service\Authenticator;
use Moulino\Framework\Auth\Exception\BadCredentialsException;

use Moulino\Framework\Http\Request;
use Moulino\Framework\Http\Response;
	
class AuthController extends BaseController
{
	public function loginAction($request) {
		$id         = $request->getParameter('login', 'POST');
		$password   = $request->getParameter('password', 'POST');
		$remoteAddr = $_SERVER['REMOTE_ADDR'];

		$auth = $this->container->get('authenticator');
		$auth->login($remoteAddr, $id, $password);

		return new Response(json_encode(''));
	}

	public function logoutAction($request) {
		$auth = $this->container->get('authenticator');
		$auth->logout();

		$response = new Response("", 301);
		$response->redirect('/');
		return $response;
	}

} ?>