<?
	class contactController extends controller {
		private $_mailer;

		public function __construct($configuration, $resourcesLoader, $external) {
			if (!array_key_exists('mailer', $external) || $external['mailer'] == null) {
				throw new Exception('Missing Mailer');
			}

			$this->_mailer = $external['mailer'];

			parent::__construct($configuration, $resourcesLoader);
		}
		
		public function index($data) {
			return $this->showView(null, $data);
		}

		public function submit($data) {
			$email = utf8_decode($data['email']->getValue());
			$name = utf8_decode($data['name']->getValue());
			$text = utf8_decode($data['text']->getValue());

			if (empty($email)) {
				throw new Exception('Missing email');
			}

			/* MAIL TO REQUESTER */
			$this->_mailer->setFrom($this->_configuration->getKey('email_from_address'), $this->_configuration->getKey('email_from_name'));
			$this->_mailer->addAddress($email, utf8_decode($name));
		 	$this->_mailer->setSubject($this->_configuration->getKey('email_title'));
		 	$this->_mailer->addHeaders(
		 		array (
		 			'Content-Type' => 'text/html; charset=UTF-8'
	 			)
	 		);

		 	$content = file_get_contents('../../front/view/template/email.html');
		 	$content = str_replace('__NAME__', $name, $content);
		 	$content = str_replace('__EMAIL__', $email, $content);
		 	$content = str_replace('__TEXT__', $text, $content);
			$this->_mailer->msgHTML($content);

          	$this->_mailer->send();


          	/* MAIL TO MARCELO */
          	$this->_mailer->newInstance();
          	$this->_mailer->setFrom($this->_configuration->getKey('email_from_address'), $this->_configuration->getKey('email_from_name'));
			$this->_mailer->addAddress($this->_configuration->getKey('email_from_address'), utf8_decode($this->_configuration->getKey('email_from_name')));
		 	$this->_mailer->setSubject('Consulta');
		 	$this->_mailer->addHeaders(
		 		array (
		 			'Content-Type' => 'text/html; charset=UTF-8'
	 			)
	 		);

			$this->_mailer->SetBody('
				Consulta de ' . $name . ':.
				Email: ' . $email . '

				' . $text
			);

			$this->_mailer->send();
		}

	}
?>