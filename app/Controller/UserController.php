<?php 

namespace App\Controller;

use Moulino\Framework\Controller\AbstractController as BaseController;
use Moulino\Framework\Http\Response;

use App\Exception\EntityNotFoundException;
use App\Exception\ChangePasswordException;
use App\Exception\JsonEncodeException;
	
class UserController extends BaseController
{
	private $model = null;
	private $translator = null;

	const USER_NOT_LOGGED = "The user is not logged";
	const USER_NOT_FOUND = "The user was not found";
	const WRONG_PASSWORD = "The old password is wrong";
	const PASSWORDS_NOT_MATCH = "The passwords do not match";

	const CREATE_PASSWORD_SUBJECT = "Your account has been created";
	const UPDATE_PASSWORD_SUBJECT = "Your password has been regenerated";

	public function __construct() {
		parent::__construct();
		$this->model = $this->getModel('user');
		$this->translator = $this->container->get('translator');
	}

	public function validate($parameters, $exclusions = array()) {
		return $this->container->get('validator')->validate($this->model, $parameters, $exclusions);
	}

	protected function notifyCreatePassword($receiver, $name, $user_id, $password) {
		$subject = $this->translator->tr(self::CREATE_PASSWORD_SUBJECT);
		$this->notify('User:create', $receiver, $subject, $name, $user_id, $password);
	}

	protected function notifyUpdatePassword($receiver, $name, $user_id, $password) {
		$subject = $this->translator->tr(self::UPDATE_PASSWORD_SUBJECT);
		$this->notify('User:update', $receiver, $subject, $name, $user_id, $password);
	}

	protected function notify($view, $receiver, $subject, $name, $user_id, $password) {
		$mailer = $this->container->get('mailer');
		$boundary = $mailer->generateBoundary();

		$mailParams = array(
			'boundary' => $boundary,
			'name'     => $name,
			'user_id'  => $user_id,
			'password' => $password
		);

		$message = $this->renderView($view, $mailParams);
		$mailer->send('fch@fch-capoulade.fr', $receiver, $subject, $message, $boundary);
	}

	protected function generatePassword() {
		$passGenerator = $this->container->get('password_generator');
		return $passGenerator->generate(8);
	}

	public function addAction($request) {
		$authenticator = $this->container->get('authenticator');

		$name = $request->getParameter('name', 'POST');
		$user_id = $request->getParameter('user_id', 'POST');
		$mail = $request->getParameter('mail', 'POST');
		$roles = $request->getParameter('roles', 'POST');

		$parameters = array(
			'name'    => $name,
			'user_id' => $user_id,
			'mail'    => $mail,
			'roles'   => $roles,
			'errors'  => 0
			);

		$password = $this->generatePassword();
		$parameters['password'] = $authenticator->encodePassword($password);

		$violations = $this->validate($parameters);

		if(!$violations->isEmpty()) {
			return $this->renderValidationInJson($violations);
		}

		$this->model->add($parameters);
		$this->notifyCreatePassword($mail, $name, $user_id, $password);

		return new Response(json_encode(''));
	}

	public function getAction($request, $id) {
		$user = $this->model->get($id);
		return new Response(json_encode($user));
	}

	public function listAction() {
		$users = $this->model->cget();
		$json = json_encode(array('users' => $users));

		if(false == $json) {
			throw new JsonEncodeException(json_last_error_msg());
		}
		return new Response($json);
	}

	public function setAction($request, $id) {
		$values = array(
			'name'    => $request->getParameter('name', 'POST'),
			'user_id' => $request->getParameter('user_id', 'POST'),
			'mail'    => $request->getParameter('mail', 'POST'),
			'roles'   => $request->getParameter('roles', 'POST')
			);

		$users = $this->model->set($id, $values);
		return new Response(json_encode(''));
	}

	public function removeAction($request, $id) {
		$this->model->remove($id);
		return new Response(json_encode(''));
	}

	public function changePasswordAction($request) {
		$authenticator = $this->container->get('authenticator');

		$oldPassword = $request->getParameter('old_password', 'POST');
		$newPassword = $request->getParameter('new_password', 'POST');
		$confirmPassword = $request->getParameter('confirm_password', 'POST');

		if(!$authenticator->checkPassword($oldPassword)) {
			throw new ChangePasswordException($this->translator->tr(self::WRONG_PASSWORD));
		}

		if($newPassword != $confirmPassword) {
			throw new ChangePasswordException($this->translator->tr(self::PASSWORDS_NOT_MATCH));
		}

		$authInfo = $authenticator->getAuthInfo();
		if('' === $authInfo['user_id']) {
			throw new ChangePasswordException($this->translator->tr(self::USER_NOT_LOGGED));
		}

		$userId = $authInfo['user_id'];
		$user = $this->model->get(array('user_id' => $userId));
		if(false == $user) {
			throw new EntityNotFoundException($this->translator->tr(self::USER_NOT_FOUND));
		}

		$passEnc = $authenticator->encodePassword($newPassword);
		if(false == $this->model->set(array('user_id' => $userId), array('password' => $passEnc))) {
			throw new ChangePasswordException($this->translator->tr($this->model->errorInfo()));
		}

		$message = $this->translator->tr("The password has been correctly updated.");
		return new Response(json_encode(array('message' => $message)));
	}

	public function regeneratePasswordAction($request) {
		$authenticator = $this->container->get('authenticator');

		$id = $request->getParameter('id', 'POST');

		$password = $this->generatePassword();
		$passEnc = $authenticator->encodePassword($password);

		$parameters = array(
			'password' => $passEnc
		);

		$this->model->set($id, $parameters);

		$user = $this->model->get($id);
		$this->notifyUpdatePassword($user['mail'], $user['name'], $user['user_id'], $password);
		return new Response(json_encode(''));
	}
};

?>