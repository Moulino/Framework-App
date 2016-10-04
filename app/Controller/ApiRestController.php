<?php

namespace App\Controller;

use Moulino\Framework\Controller\AbstractController as BaseController;
use Moulino\Framework\Http\Response;
use Moulino\Framework\Core\Exception\BadRequestException;
use Moulino\Framework\Config\Config as AppConfig;

class ApiRestController extends BaseController
{
	private $model = null;
	private $validator = null;
	private $authenticator = null;

	public function __construct() {
		parent::__construct();

		$this->validator = $this->container->get('validator');
		$this->authenticator = $this->container->get('authenticator');
	}

	public function loginAction($request) {
		$content = $request->getContent();
		$parameters = json_decode($content, true);

		$username = $parameters['login'];
		$password = $parameters['password'];
		$remoteAddr = $_SERVER['REMOTE_ADDR'];

		$token = $this->authenticator->login($remoteAddr, $username, $password);

		$data = array(
			'message' => "successfully authenticated",
			'token' => $token
		);

		return new Response(json_encode($data));
	}

	public function addAction($request, $modelName) {
		$model = $this->getModel($modelName);
		$content = $request->getContent();

		$parameters = json_decode($content, true);

		$violations = $this->validator->validate($model, $parameters);
		if(!$violations->isEmpty()) {
			return $this->renderValidationInJson($violations);
		}
		$model->add($parameters);
		return new Response(json_encode(''));
	}

	public function getAction($request, $modelName, $id) {
		$model = $this->getModel($modelName);
		$response = new Response();

		$item = $model->get($id);
		$content = json_encode($item);

		$response->setContent($content);
		return $response;
	}

	public function removeAction($request, $modelName, $id) {
		$model = $this->getModel($modelName);
		$model->remove($id);
		return new Response(json_encode(""));
	}

	public function updateAction($request, $modelName, $id) {
		$model = $this->getModel($modelName);
		$content = $request->getContent();

		$parameters = json_decode($content, true);

		$violations = $this->validator->validate($model, $parameters, ['unique']);
		if(!$violations->isEmpty()) {
			return $this->renderValidationInJson($violations);
		}

		$model->set($id, $parameters);
		return new Response(json_encode(''));
	}

	public function listAction($request, $modelName) {
		$model = $this->getModel($modelName);
		$response = new Response();

		$filters = "";

		$page = $request->getParameter('_page');
		$perPage = $request->getParameter('_perPage');
		$sortDir = $request->getParameter('_sortDir');
		$sortField = $request->getParameter('_sortField');
		$offset = ($page -1) * $perPage;

		if(isset($sortField) && isset($sortDir)) {
			$filters .= "ORDER BY `$sortField` $sortDir ";
		}

		if(isset($page) && isset($perPage)) {
			$filters .= "LIMIT $perPage OFFSET $offset ";
		}

		$filters = trim($filters);

		$items = $model->cget(array(), $filters);
		$totalCount = $model->count();
		$content = json_encode($items);

		$response->setContent($content);
		$response->setHeaders(array('X-Total-Count' => $totalCount));
		return $response;
	}

	public function contactSubmissionAction($request) {
		$method = $request->getMethod();

		$errors = array();
		if('POST' === $method) {
			$mailParams = json_decode($request->getContent(), 1);

			if(!isset($mailParams['lastname'])) {
				$errors['lastname'] = "Veuillez renseigner votre nom";
			}

			if(!isset($mailParams['firstname'])) {
				$errors['firstname'] = "Veuillez renseigner votre prénom";
			}

			if(!isset($mailParams['mail'])) {
				$errors['mail'] = "Veuillez renseigner votre adresse e-mail";
			}

			if(!isset($mailParams['telephone'])) {
				$mailParams['telephone'] = '';
			}

			if(!isset($mailParams['subject'])) {
				$errors['subject'] = "Veuillez renseigner l'objet du message";
			}

			if(!isset($mailParams['message'])) {
				$errors['message'] = "Veuillez rédiger le contenu du message";
			}

			if(empty($errors)) {
				$mailer = $this->container->get('mailer');
				$boundary = $mailer->generateBoundary();
				$mailParams['boundary'] = $boundary;

				$message = $this->renderView('Contact:mail', $mailParams);
				$receiver = AppConfig::get('mailer.receiver');

				$mailer->send($mailParams['mail'], $receiver, $mailParams['subject'], $message, $boundary);

				return new Response();
			}
		} else {
			throw new BadRequestException("Une erreur interne est survenue. Le message n'a pas été envoyé.");
		}

		return new Response(json_encode($errors), 400);
	}
}