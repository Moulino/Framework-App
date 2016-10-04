<?php 

namespace App\Controller;

use Moulino\Framework\Controller\AbstractController as BaseController;
use Moulino\Framework\Exception\LoginException;

use Moulino\Framework\Http\Request;
use Moulino\Framework\Http\Response;
	
class ArticleController extends BaseController
{
	public function setAction($request, $id) {
		$content = $request->getParameter('content', 'POST');
		$this->container->get('article_handler')->set($id, $content);

		$translator = $this->container->get('translator');
		$message = $translator->tr("The article has been correctly updated.");
		return new Response(json_encode(array('message' => $message)));
	}

} ?>