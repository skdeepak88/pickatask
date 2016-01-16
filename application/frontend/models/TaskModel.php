<?
namespace Mercury\App\Frontend\Models;

use Mercury\Helper\Model;

class TaskModel extends Model {


	protected function initmodel() {

		// Set this because the table name is not in standard format
		$this->settable('task');

	}

	public function gettasks($po_search) {

		if(empty($po_search))
			return false;


		// Initialise the query variables
		$la_where = array();
		$la_binds = array();

		// Start constructing the query
		if(isset($po_search->taskid) && !empty($po_search->taskid)){
			$la_where[] = ' AND t.`taskid` = :taskid';
			$la_binds['taskid'] = $po_search->taskid;
		}

		if(isset($po_search->hash) && !empty($po_search->hash)){
			$la_where[] = ' AND t.`hash` = :hash';
			$la_binds['hash'] = $po_search->hash;
		}

		if(isset($po_search->status) && !empty($po_search->status)){
			$la_where[] = ' AND t.`status` = :status';
			$la_binds['status'] = $po_search->status;
		}

		if(isset($po_search->statusexclude) && !empty($po_search->statusexclude)){
			$la_where[] = ' AND t.`status` != :status';
			$la_binds['status'] = $po_search->statusexclude;
		}

		if(isset($po_search->family) && !empty($po_search->family)){
			$la_where[] = ' AND t.`family` = :family';
			$la_binds['family'] = $po_search->family;
		}

		if(isset($po_search->advertiserid) && !empty($po_search->advertiserid)){
			$la_where[] = ' AND t.`advertiserid` = :advertiserid';
			$la_binds['advertiserid'] = $po_search->advertiserid;
		}


		// The base query
		$ls_sql = "SELECT t.*, tc.`criteriaid`, c.`group` as taskgroup
					FROM `task` t
					LEFT JOIN `taskcriteria` tc ON tc.`taskid` = t.`taskid`
					LEFT JOIN `criteria` c ON c.`criteriaid` = tc.`criteriaid`
					WHERE TRUE " . implode(PHP_EOL, $la_where) ."
					ORDER BY NULL";

		//$this->gs->debug($ls_sql);

		// Fetch the raw results
		$la_results = $this->db->getallobjects($ls_sql, $la_binds);

		// Process the results
		$la_tasks = array();

		foreach($la_results as $lo_item) {

			$li_taskid = $lo_item->taskid;
			$li_criteriaid = $lo_item->criteriaid;
			$ls_criteriagroup = $lo_item->taskgroup;

			if(!isset($la_tasks[$li_taskid])){
				$la_tasks[$li_taskid] = $lo_item;
				$la_tasks[$li_taskid]->criteria = array();
			}

			$la_tasks[$li_taskid]->criteria[$ls_criteriagroup][$li_criteriaid] = $li_criteriaid;
		}

		return $la_tasks;
	}


	public function gettask($po_search) {

		$la_tasks = $this->gettasks($po_search);

		if(!is_array($la_tasks))
			return false;

		$lo_task = current($la_tasks);

		return $lo_task;
	}


	public function getvalidtasks($po_account){

		// Initialise empty task holder
		$la_validtasks = array();

		if(!is_object($lo_account))
			return $la_validtasks;

		// Get possible criteria for account
		$la_acriteria = $lo_account->criteria;

		// Get all the tasks
		$lo_search = new stdClass;
		$lo_search->status = 'APPROVED';
		$la_activetasks = $this->gettasks($lo_search);

		/**
		 * Loop through the active tasks and check criteria condition
		 * The rule is if the task has a criteria set in the group
		 * we need to have the account matching the criteria in same group
		 */
		foreach($la_activetasks as $lo_task) {

			$la_tcriteria = $lo_task->criteria;
			$la_criteriagroup = array_keys($la_tcriteria);

			$lb_valid = true;

			foreach($la_tcriteria as $ls_tgroup => $la_tcriteriaid) {

				if(!isset($la_acriteria[$ls_tgroup])){
					$lb_valid = false;
					break;
				}

				$la_acriteriaid = $la_acriteria[$ls_tgroup];

				if(count(array_intersect($la_tcriteriaid, $la_acriteriaid)) < count($la_tcriteriaid)){
					$lb_valid = false;
					break;
				}
			}

			if($lb_valid){

				// Add account details also to the task
				$lo_task->accountdetail = $lo_account;

				$la_validtasks[$lo_task->taskid] = $lo_task;
			}
		}

		return $la_validtasks;
	}

	public function validatetask($pi_taskid, $pi_accountid) {

		if(empty($pi_taskid))
			return false;

		if(empty($pi_accountid))
			return false;

		$la_tasks = $this->getvalidtasks($pi_accountid);

		// Check if the task exists
		$lb_valid = isset($la_tasks[$pi_taskid]) ? true : false;

		return $lb_valid;
	}

	public function gettaskassets($po_search) {

		if(empty($po_search))
			return false;

		// Initialise the query variables
		$la_where = array();
		$la_binds = array();

		// Start constructing the query
		if(isset($po_search->taskid) && !empty($po_search->taskid)){
			$la_where[] = ' AND t.`taskid` = :taskid';
			$la_binds['taskid'] = $po_search->taskid;
		} else {
			$la_where[] = ' AND t.`taskid` = 0';
		}

		if(isset($po_search->type) && !empty($po_search->type)){
			$la_where[] = ' AND t.`type` = :type';
			$la_binds['type'] = $po_search->type;
		}

		if(isset($po_search->family) && !empty($po_search->family)){
			$la_where[] = ' AND t.`family` = :family';
			$la_binds['family'] = $po_search->family;
		}

		if(isset($po_search->advertiserid) && !empty($po_search->advertiserid)){
			$la_where[] = ' AND t.`advertiserid` = :advertiserid';
			$la_binds['advertiserid'] = $po_search->advertiserid;
		}

		// The base query
		$ls_sql = "SELECT t.*
					FROM `taskasset` t
					WHERE TRUE " . implode(PHP_EOL, $la_where) ."
					ORDER BY NULL";

		//$this->gs->debug($ls_sql);

		// Fetch the raw results
		$la_results = $this->gs->getallobjects($ls_sql, $la_binds);

		return $la_results;
	}

}