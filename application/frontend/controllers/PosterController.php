<?
namespace Mercury\App\Frontend\Controllers;

use Mercury\Helper\Controller;
use Mercury\App\Helpers\Auth;
use Mercury\App\Frontend\Models\AccountModel;
use Mercury\App\Frontend\Models\TaskModel;

class PosterController extends Controller {

	private $auth;
	private $accountmodel;

	public function initcontroller() {

		$this->auth = new Auth($this->di);

		// Init the momdels
		$this->accountmodel = new AccountModel($this->di);
		$this->taskmodel = new TaskModel($this->di);

		// Check if its authorised
		$ls_route = $this->geturlparameter(0);
		$this->auth->authorisepage($ls_route);
	}

	public function posterAction() {

		$lo_user = $this->auth->inituser();

		// Get all accounts
		$lo_search = new \stdClass;
		$lo_search->posterid = $lo_user->userid;

		$la_accounts = $this->accountmodel->getaccounts($lo_search);

		$la_tasks = array();

		foreach ($la_accounts as $lo_account) {
			$la_active = $this->taskmodel->getvalidtasks($lo_account);
			array_merge($la_tasks, $la_active);
		}

		$this->buildtemplatedata(['lo_user' => $lo_user]);
		$this->buildresponse(['la_accounts' => $la_accounts]);
		$this->buildresponse(['la_tasks' => $la_tasks]);

	}




}