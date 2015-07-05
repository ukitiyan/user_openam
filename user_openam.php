<?php

/**
 * ownCloud - user_openam
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Begood Technology Corp. <y-takahashi@begood-tech.com>
 * @copyright Begood Technology Corp. 2014
 * */

OCP\App::checkAppEnabled('user_openam');

class OC_USER_OPENAM extends OC_User_Backend {

	public $iPlanetDirectoryPro;
	public $loginName;

    public function __construct() {

    }

    public function checkPassword($uid, $password) {
		foreach (getallheaders() as $name => $value) {
			if ($name === 'iPlanetDirectoryPro') {
				$this->iPlanetDirectoryPro = $value;
			}
			if ($name === 'user') {
				$this->loginName = $value;
			}
		}

		if (!empty($this->loginName)) {
			if(!OCP\User::userExists($this->loginName)) {
				return $this->createUser($this->loginName);
			}

			return $this->loginName;
		} else {
			return null;
		}
    }

	private function createUser($uid) {
		if (preg_match( '/[^a-zA-Z0-9 _\.@\-]/', $uid)) {
			OCP\Util::writeLog('saml','Invalid username "'.$uid.'", allowed chars "a-zA-Z0-9" and "_.@-" ',OCP\Util::DEBUG);
			return false;
		} else {
			$random_password = \OC::$server->getSecureRandom()->getMediumStrengthGenerator()->generate(64);
			OCP\Util::writeLog('user_openam','Creating new user: '.$uid, OCP\Util::DEBUG);
			OC_User::createUser($uid, $random_password);
			return $uid;
		}
	}

}
