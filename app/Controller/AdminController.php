<?php

namespace App\Controller;
	
use Moulino\Framework\Controller\AbstractController as BaseController;
use Moulino\Framework\Config\Config;
use Moulino\Framework\Http\Response;
	
class AdminController extends BaseController
{
	public function indexAction() {
		return $this->render('Admin:index', array());
	}

	public function uploadAction() {
		$fileInfo = $_FILES['file'];
		$extension = $this->getExtensionFromFilename($fileInfo['name']);
		$newFilename = uniqid().'.'.$extension;
		$destination = WEBROOT.DS.'upload'.DS.$newFilename;

		if(!is_uploaded_file($fileInfo['tmp_name'])) {
			throw new InternalErrorException($this->translator->tr('The file has not been uploaded correctly.'));
		}

		if($fileInfo['size'] > 104857600) {
			throw new BadRequestException($this->translator->tr('The file is too large.'));
		}

		if($fileInfo['error'] > 0) {
			throw new UploadException($this->translator->tr("Error in uploading this file"), $fileInfo['error']);
		}

		if(! move_uploaded_file($fileInfo['tmp_name'], $destination)) {
			throw new InternalErrorException($this->translator->tr("Unable to save this file."));
		}

		return new Response(json_encode(['filename' => '/web/upload/'.$newFilename]));
	}

	private function getExtensionFromFilename($filename) {
		if(preg_match('#\.(\w{3})$#', $filename, $matches)) {
			return strtolower($matches[1]);
		}
	}

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
}

?>