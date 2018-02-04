<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
		public function getSignOut($request, $response)
		{
				$this->c->auth->logout();

				return $response->withRedirect($this->c->router->pathFor('home'));
		}

		public function getSignIn($request, $response)
		{
				return $this->c->view->render($response, 'auth/signin.twig');
		}

		public function postSignIn($request, $response)
		{
				$auth = $this->c->auth->attempt(
						$request->getParam('email'),
						$request->getParam('password')
				);

				if (!$auth) {
						$this->c->flash->addMessage('error', 'Could not sign you in with those details!');
						return $response->withRedirect($this->c->router->pathFor('auth.signin'));
				}

				return $response->withRedirect($this->c->router->pathFor('home'));
		}

		public function getSignUp($request, $response)
		{
				return $this->c->view->render($response, 'auth/signup.twig');
		}

		public function postSignUp($request, $response)
		{
			$validation = $this->c->validator->validate($request, [
					'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
					'name' => v::notEmpty()->alpha(),
					'password' => v::noWhitespace()->notEmpty()
			]);

			if ($validation->failed()) {
					return $response->withRedirect($this->c->router->pathFor('auth.signup'));
			}

			$user = User::create([
					'email' => $request->getParam('email'),
					'name' => $request->getParam('name'),
					'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
			]);

			$this->c->flash->addMessage('info', 'You have been signed up!');

			$auth = $this->c->auth->attempt($user->email, $request->getParam('password'));
			
			return $response->withRedirect($this->c->router->pathFor('home'));
		}
}