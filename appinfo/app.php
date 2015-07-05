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


use \OCP\App;

if (App::isEnabled('user_openam') && (isset($_GET['app']) && $_GET['app'] === 'user_openam')) {

	require_once 'user_openam/user_openam.php';

	//App::registerAdmin('user_openam', 'settings');

	// register user backend
	OC_User::useBackend( 'OPENAM' );

	OC::$CLASSPATH['OC_USER_OPENAM_Hooks'] = 'user_openam/lib/hooks.php';
	OCP\Util::connectHook('OC_User', 'post_login', 'OC_USER_OPENAM_Hooks', 'post_login');
	OCP\Util::connectHook('OC_User', 'logout', 'OC_USER_OPENAM_Hooks', 'logout');


	if (!OC_User::login('', '')) {
		$error = true;
		OCP\Util::writeLog('user_openam','Error trying to authenticate the user', OCP\Util::DEBUG);
	}

	if (isset($_GET["linktoapp"])) {
		$path = OC::$WEBROOT . '/?app='.$_GET["linktoapp"];
		if (isset($_GET["linktoargs"])) {
			$path .= '&'.urldecode($_GET["linktoargs"]);
		}
		header( 'Location: ' . $path);
		exit();
	}
	OC::$REQUESTEDAPP = '';
	OC_Util::redirectToDefaultPage();
}

