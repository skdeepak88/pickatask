<?
namespace Mercury\App\Helpers;

use Mercury\Helper\Core;
use Mercury\App\Frontend\Models\LoginModel;

class Auth extends Core {

	private $loginmodel;

	public function __construct($di) {

		$this->defaulttemplate = __DIR__ . '/../views/templates';

		$this->loginmodel = new LoginModel($di);
	}

	/**
	 * Initialize the current logged in user and returns the user object
	 * Initializing includes any user specific fields actions
	 * @return object
	 */
	public function inituser(){

		$ls_email = isset($_COOKIE['site_user_email']) ? $_COOKIE['site_user_email'] : '';
		$ls_session = isset($_COOKIE['site_user_session']) ? $_COOKIE['site_user_session'] : '';

		if(empty($ls_email) || empty($ls_session)){
			$this->logout();
			return false;
		}

		$lo_user = $this->loginmodel->getuser($ls_email);

		// Check if the session is still valid
		if($ls_session === $lo_user->session)
			return $lo_user;

		$this->logout();
		return false;
	}


	public function authorisepage($po_page){

		$lo_user = $this->inituser();

		$ls_page = strtolower($po_page->action);

		if(!is_object($lo_user) && empty($ls_page))
			return false;

		elseif(!is_object($lo_user) && $ls_page != 'login')
			$this->redirect("/login");

		elseif(!is_object($lo_user) && $ls_page == 'login')
			return false;

		if($ls_page == 'login' && $lo_user->type == 'ADVERTISER')
			$this->redirect("/advertiser");

		elseif($ls_page == 'login' && $lo_user->type == 'POSTER')
			$this->redirect("/poster");

		elseif(empty($lo_user->type) && $ls_page != 'pickaside')
			$this->redirect("/pickaside");

		$la_advertiserpages = array('advertiser', 'managetask', 'taskbids');

		if($lo_user->type != 'ADVERTISER' && in_array($ls_page, $la_advertiserpages)){
			$this->logout();
			$this->redirect("/login");
		}

		$la_posterpages = array('poster', 'accounts', 'manageaccount' ,'task');

		if($lo_user->type != 'POSTER' && in_array($ls_page, $la_posterpages)){
			$this->logout();
			$this->redirect("/login");
		}

		return true;
	}

	/**
	 * Pretty self explainatory. Just logs out :)
	 * @return boolean
	 */
	public function logout(){

		setcookie('site_user_email', null, time()-60*60*24*30, '/');
		setcookie('site_user_session', null, time()-60*60*24*30, '/');

		return true;
	}

}