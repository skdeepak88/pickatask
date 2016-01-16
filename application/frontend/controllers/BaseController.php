<?
namespace Mercury\App\Frontend\Controllers;

use Mercury\Helper\Controller;
use Mercury\App\Helpers\Auth;

class BaseController extends Controller {


	private $auth;
	public $user;


	public function initcontroller() {

		$this->auth = new Auth($this->di);

		// Check if page is authorised
		$this->auth->authorisepage($this->currentpage);

		// Get the user
		$this->user = $this->auth->inituser();

		$this->buildtemplatedata(['lo_user' => $this->user]);
	}

}