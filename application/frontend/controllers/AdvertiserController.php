<?
namespace Mercury\App\Frontend\Controllers;

use Mercury\App\Frontend\Models\TaskModel;

class AdvertiserController extends BaseController {

	private $auth;
	private $taskmodel;


	public function initcontroller() {

		parent::initcontroller();

		// Init the momdels
		$this->taskmodel = new TaskModel($this->di);

	}

	public function dashboardAction() {

		$this->setview('advertiser');

		$lo_user = $this->user;

		$lo_search = new \stdClass;
		$lo_search->status = 'APPROVED';
		$lo_search->advertiserid = $lo_user->userid;
		$la_active = $this->taskmodel->gettasks($lo_search);

		foreach ($la_active as $lo_task) {
			$lo_task->taskurl = $this->gettaskurl($lo_task);
		}

		$lo_search = new \stdClass;
		$lo_search->status = 'PROCESSING';
		$lo_search->advertiserid = $lo_user->userid;
		$la_pending = $this->taskmodel->gettasks($lo_search);

		foreach ($la_pending as $lo_task) {
			$lo_task->taskurl = $this->gettaskurl($lo_task);
		}

		$lo_search = new \stdClass;
		$lo_search->status = 'COMPLETED';
		$lo_search->advertiserid = $lo_user->userid;
		$la_history = $this->taskmodel->gettasks($lo_search);

		foreach ($la_history as $lo_task) {
			$lo_task->taskurl = $this->gettaskurl($lo_task);
		}

		$this->buildresponse(['la_active' => $la_active]);
		$this->buildresponse(['la_pending' => $la_pending]);
		$this->buildresponse(['la_history' => $la_history]);
	}

	private function gettaskurl($po_task) {

		if(!is_object($po_task))
			return '#';

		switch($po_task->family) {

			case 'BLOGPOST':
				return '/managetask/blogpost/'.$po_task->taskid;

			default:
				return "#";
		}

	}

}