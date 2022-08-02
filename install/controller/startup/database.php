<?php
namespace Opencart\Install\Controller\Startup;
class Database extends \Opencart\System\Engine\Controller {
	public function index(): void {
		echo DIR_OPENCART;
		if (is_file(DIR_OPENCART . 'config.php')) {
			$config = [];
			echo DIR_OPENCART;
			$lines = file(DIR_OPENCART . 'config.php');
			echo $lines;
			foreach ($lines as $number => $line) {
				echo $line;
				if (strpos(strtoupper($line), 'DB_') !== false && preg_match('/define\(\'(.*)\',\s+\'(.*)\'\)/', $line, $match, PREG_OFFSET_CAPTURE)) {
					define($match[1][0], $match[2][0]);
				}
			}

			if (defined('DB_PORT')) {
				echo DB_PORT;
				$port = DB_PORT;
			} else {
				echo 'No port';
				$port = ini_get('mysqli.default_port');
			}
			
			$this->registry->set('db', new \Opencart\System\Library\DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, $port));
		}
	}
}
