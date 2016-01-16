<?
namespace Mercury\App\Frontend\Controllers;

use Mercury\Helper\Controller;
use Mercury\App\Frontend\Models\LoginModel;
use Mercury\App\Helpers\Auth;

class LoginController extends Controller {

	private $loginmodel;
	private $auth;


	public function initcontroller() {

		$this->loginmodel = new LoginModel($this->di);
		$this->auth = new Auth($this->di);

		$this->auth->authorisepage($this->currentpage);
	}

	public function loginAction($ps_action = null) {

		// echo "Sample file";

		switch($ps_action) {

			case 'authenticate':

				$ls_email = $this->postvalue("email");
				$ls_password = $this->postvalue("password");

				// Validate the fields
				if(!$this->checkemail($ls_email))
					$this->seterror("Please check your email");

				if(empty($ls_password))
					$this->seterror("Please enter your password");

				$la_errors = $this->geterrors();
				if(!empty($la_errors)){
					$this->setflashmessage($la_errors, 'WARNING');
					break;
				}

				/**
				 * 1. Chech if the login exists
				 * 2. If not exists create one
				 * 3. If exists try to login
				 */

				// 1. Chech if the login exists
				$lo_user = $this->loginmodel->getuser($ls_email);

				// 2. If not exists create one
				if(!is_object($lo_user)){

					$ls_key = $this->getrandomhash();

					$la_insert = array();
					$la_insert['email'] = $ls_email;
					$la_insert['hash'] = $this->stringhash($ls_password);
					$la_insert['activationkey'] = $ls_key;
					$la_insert['created'] = date('Y-m-d H:i:s');

					$li_userid = $this->dbinsert('user', $la_insert);

					// Send authentication email
					$lo_mail = $this->getmailobject();
					$lo_mail->AddAddress($ls_email);

					$la_fields = array();
					$la_fields['URL'] = $this->gethost().'/activateaccount/'.$ls_key;

					$ls_content = $this->getemailcontent('email-activation', $la_fields);

					$lo_mail->Subject = 'Activate your account';
					$lo_mail->Body = $ls_content;

					//$this->Debugx($lo_mail);

					$lb_sent = $lo_mail->Send();

					if($lb_sent)
						$this->savesentemail($li_userid, $ls_email, 'Activate your account', $ls_content);

					$this->setflashmessage("You are registered now. Please check your email to activate your account.", 'INFO');
					break;
				}

				$lb_authenticated = $this->authenticate($ls_email, $ls_password);

				if($lb_authenticated)
					$this->redirect("/");

			break;

			case 'pickadvertiser':

				$lo_user = $this->inituser();

				if(!is_object($lo_user)){
					$this->setflashmessage("Please login before choosing a side");
					$this->redirect("/login");
				}

				if(!empty($lo_user->type)) {
					$this->setflashmessage("You have already chosen your side");
					$this->redirect("/pickaside");
				}

				$la_update = array();
				$la_update['type'] = 'ADVERTISER';

				$this->dbupdate('user', 'userid', $lo_user->userid, $la_update);

				$this->redirect('/');
			break;

			case 'pickposter':

				$lo_user = $this->inituser();

				if(!is_object($lo_user)){
					$this->setflashmessage("Please login before choosing a side");
					$this->redirect("/login");
				}

				if(!empty($lo_user->type)) {
					$this->setflashmessage("You have already chosen your side");
					$this->redirect("/pickaside");
				}

				$la_update = array();
				$la_update['type'] = 'POSTER';

				$this->dbupdate('user', 'userid', $lo_user->userid, $la_update);

				$this->redirect('/');

			break;

		}
	}


	public function logoutAction() {

		$this->auth->logout();

		$this->redirect('/');
	}

	/**
	 * Authenticate the user, set the cookies and update the database
	 * with session hash and last logged in datetime
	 * @param  string $ps_email
	 * @param  string $ps_password
	 * @return boolean
	 */
	private function authenticate($ps_email, $ps_password) {

		if(empty($ps_email))
			return false;

		if(empty($ps_password))
			return false;

		$lo_user = $this->loginmodel->getuser($ps_email);

		if(!is_object($lo_user))
			return false;


		// Check if the password is correct
		if(!$this->verifyhash($ps_password, $lo_user->hash)){
			$this->setflashmessage("Email/Password is incorrect.", 'WARNING');
			return false;
		}

		// Check if the user is activated
		if(empty($lo_user->activated) || strtotime($lo_user->activated) <= 0){
			$this->setflashmessage("The account is not yet activated. Please check your email.");
			return false;
		}

		if(empty($lo_user->active)){
			$this->setflashmessage("The account is not active. Please contact us.");
			return false;
		}

		// Update the cookies and DB session
		$la_update = array();
		$la_update['session'] = $this->getrandomhash();
		$la_update['lastlogin'] = date('Y-m-d H:i:s');

		$this->loginmodel->updateuser($lo_user->userid, $la_update);

		setcookie('site_user_email', $lo_user->email, time()+60*60*24*30, '/');
		setcookie('site_user_session', $la_update['session'], time()+60*60*24*30, '/');

		return true;
	}

}