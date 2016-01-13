<?

	include_once('phpmailer/PHPMailerAutoload.php');

	class mailer {
		private $_library;
		private $_configuration;
		
		public function mailer($configuration) {
			if ($configuration == null) {
				throw new Exception('Missing Configuration module.');
			}


			$this->_configuration = $configuration;
			$this->newInstance();
		}


		private function configure() {
	        $this->_library->IsSMTP();
	        $this->_library->SMTPAuth = true;
	        $this->_library->Host = $this->_configuration->getKey('smtp_host');
	        $this->_library->Helo = $this->_configuration->getKey('smtp_host');
	        $this->_library->Username = $this->_configuration->getKey('smtp_user');
	        $this->_library->Password = $this->_configuration->getKey('smtp_password');
	        $this->_library->SMTPDebug = true;
	        $this->_library->SMTPAuth = true;
	        $this->_library->SMTPSecure = "tls";
	        $this->_library->Port = $this->_configuration->getKey('smtp_port'); //SMTPPORT;
	        $this->_library->WordWrap = 50;

	        $this->_library->SMTPOptions['ssl'] = array(
        		'verify_peer' => false, 
        		'verify_peer_name' => false, 
        		'allow_self_signed' => true
    		);
		}

		public function newInstance() {
			$this->_library = new PHPMailer(true);
			$this->configure();
		}

		public function addHeaders($headers) {
			foreach ($headers as $headerKey => $headerValue) {
				$this->_library->set($headerKey, $headerValue);
			}
		}

		public function setSubject($subject) {
			$this->_library->Subject = $subject;
		}

		public function setBody($body) {
			$this->_library->Body = $body;
		}

		public function setFrom($email, $name) {
			$this->_library->setFrom($email, $name);
		}

		public function addAddress($email, $name) {
			$this->_library->addAddress($email, $name);
		}

		public function msgHTML($html) {
			$this->_library->msgHTML($html);
		}

		public function send() {
			try{
	            if (!$this->_library->Send())
	                die('No se pudo enviar el mail.');
	        } catch (phpmailerException $e) {
	            die ($e->errorMessage());
	        } catch (Exception $e) {
	            die ($e->getMessage());
	        }
		}
	}

?>