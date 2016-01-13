<?

	define('ALIAS_RESOURCE_URL_PREFIX', 'RESOURCE_URL_');
	define('ROOT_RESOURCE_URL_ALIAS', 'ROOT');
	class resourceLoader {
		private $_resource_location;
		private $_resource_folders;
		private $_resource_extensions_per_folders;

		function resourceLoader($urlPrefix) {
			$this->_resource_location = 'http://' . $_SERVER['HTTP_HOST'] . '/' . (!empty($urlPrefix) ? $urlPrefix  . '/' : '') . 'front/resource/';

			$this->register('WEB_RESOURCE_CSS', 'css/');
			$this->register('WEB_RESOURCE_JS', 'js/');
			$this->register('WEB_RESOURCE_FONT', 'font/');
			$this->register('WEB_RESOURCE_IMG', 'img/');
		}

		function register($alias, $location, $options = null) {
			if ($this->_resource_folders == null) {
				$this->_resource_folders = array();
			}

			if ($options == null) {
				$options = array(
					'parentAlias' => ROOT_RESOURCE_URL_ALIAS
				);
			}

			$parentAlias = ALIAS_RESOURCE_URL_PREFIX . $options['parentAlias'];
			$alias = ALIAS_RESOURCE_URL_PREFIX . $alias;

			// inserts folder in paths system.
			array_push($this->_resource_folders, array('alias' => $alias, 'url' => $this->getCompleteUrl($location, $parentAlias)));
		}

		function getCompleteUrl($location, $parentAlias) {
			$parentUrl = '';

			if ($parentAlias == (ALIAS_RESOURCE_URL_PREFIX . ROOT_RESOURCE_URL_ALIAS)) {
				// its parent is the root
				$parentUrl = $this->_resource_location;
			} else {
				$parentUrl = $this->getUrlByAlias($parentAlias);
			}

			if (empty($parentUrl)) {
				throw new Exception('The parent url has not been registered.');
			}

			return $parentUrl . $location;
		}

		function getUrlByAlias($alias) {
			$parentUrl = null;

			foreach ($this->_resource_folders as $registeredPath) {
				if ($registeredPath['alias'] == $alias) {
					$parentUrl = $registeredPath['url'];
				}
			}

			return $parentUrl;
		}

		function resolvePath ($alias, $filename) {
			$alias = ALIAS_RESOURCE_URL_PREFIX . $alias;
			return $this->getUrlByAlias($alias) . $filename;
		}

	}

?>