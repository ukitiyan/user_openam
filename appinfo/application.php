<?php
/**
 * ownCloud - user_openam
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Begood Technology Corp. <y-takahashi@begood-tech.com>
 * @copyright Begood Technology Corp. 2014
 */

namespace OCA\user_openam\AppInfo;


use \OCP\AppFramework\App;
use \OCP\IContainer;

use \OCA\OcAudit\Controller\PageController;

class Application extends App {

	public function __construct (array $urlParams=array()) {
		parent::__construct('user_openam', $urlParams);

	}
}