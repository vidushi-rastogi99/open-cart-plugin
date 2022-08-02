<?php
namespace Opencart\Install\Controller\Startup;
class Database extends \Opencart\System\Engine\Controller {
	public function index(): void {
		echo DIR_OPENCART;
		echo nl2br("\n.....000.....\n");
		echo filesize(DIR_OPENCART . 'config.php');
		if (is_file(DIR_OPENCART . 'config.php') && filesize(DIR_OPENCART . 'config.php') > 0) {
			$config = [];
			echo nl2br("\n.....111.....\n");
			echo DIR_OPENCART;
			$lines = file(DIR_OPENCART . 'config.php');
			echo nl2br("\n.....222.....\n");
			echo '<pre>'; print_r($lines); echo '</pre>';
			foreach ($lines as $number => $line) {
				echo nl2br("\n.....333.....\n");
				echo $line;
				if (strpos(strtoupper($line), 'DB_') !== false && preg_match('/define\(\'(.*)\',\s+\'(.*)\'\)/', $line, $match, PREG_OFFSET_CAPTURE)) {
					define($match[1][0], $match[2][0]);
				}
			}

			if (defined('DB_PORT')) {
				echo nl2br("\n.....444.....\n");
				echo DB_PORT;
				$port = DB_PORT;
			} else {
				echo nl2br("\n.....555.....\n");
				echo 'No port';
				$port = ini_get('mysqli.default_port');
			}
			
			$this->registry->set('db', new \Opencart\System\Library\DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, $port));
		}
	}
}
