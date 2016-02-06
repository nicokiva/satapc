<?

	class responseCode {
		public static $notFound = 'HTTP/1.0 404 Not Found';
	}

	class response {

		private function respond($header) {
			header($header);
		}

		public function notFound() {
			header(responseCode::$notFound);
		}

	}

?>