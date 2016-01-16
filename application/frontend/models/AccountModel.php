<?
namespace Mercury\App\Frontend\Models;

use Mercury\Helper\Model;

class AccountModel extends Model {


	protected function initmodel() {

		// Set this because the table name is not in standard format
		$this->settable('account');

	}


	public function getaccounts($po_search) {

		if(empty($po_search))
			return false;


		// Initialise the query variables
		$la_where = array();
		$la_binds = array();

		// Start constructing the query
		if(isset($po_search->accountid) && !empty($po_search->accountid)){
			$la_where[] = ' AND a.`accountid` = :accountid';
			$la_binds['accountid'] = $po_search->accountid;
		}

		if(isset($po_search->status) && !empty($po_search->status)){
			$la_where[] = ' AND a.`status` = :status';
			$la_binds['status'] = $po_search->status;
		}

		if(isset($po_search->statusexclude) && !empty($po_search->statusexclude)){
			$la_where[] = ' AND a.`status` != :status';
			$la_binds['status'] = $po_search->statusexclude;
		}

		if(isset($po_search->family) && !empty($po_search->family)){
			$la_where[] = ' AND a.`family` = :family';
			$la_binds['family'] = $po_search->family;
		}

		if(isset($po_search->posterid) && !empty($po_search->posterid)){
			$la_where[] = ' AND a.`posterid` = :posterid';
			$la_binds['posterid'] = $po_search->posterid;
		}


		// The base query
		$ls_sql = "SELECT a.*, ac.`criteriaid`, c.`group` as accountgroup
					FROM `account` a
					LEFT JOIN `accountcriteria` ac ON ac.`accountid` = a.`accountid`
					LEFT JOIN `criteria` c ON c.`criteriaid` = ac.`criteriaid`
					WHERE TRUE " . implode(PHP_EOL, $la_where) ."
					ORDER BY NULL";

		// Fetch the raw results
		$la_results = $this->db->getallobjects($ls_sql, $la_binds);

		// Process the results
		$la_accounts = array();

		foreach($la_results as $lo_item) {

			$li_accountid = $lo_item->accountid;
			$li_criteriaid = $lo_item->criteriaid;
			$ls_criteriagroup =$lo_item->accountgroup;

			if(!isset($la_accounts[$li_accountid])){
				$la_accounts[$li_accountid] = $lo_item;
				$la_accounts[$li_accountid]->criteria = array();
			}

			$la_accounts[$li_accountid]->criteria[$ls_criteriagroup][$li_criteriaid] = $li_criteriaid;
		}

		return $la_accounts;
	}


	public function getaccount($po_search) {

		$la_accounts = $this->getaccounts($po_search);

		if(!is_array($la_accounts))
			return false;

		$lo_account = current($la_accounts);

		return $lo_account;
	}


	public function validateaccount($pi_accountid) {

		if(empty($pi_accountid))
			return false;

		$lo_user = $this->inituser();

		$lo_search = new stdClass;
		$lo_search->posterid = $lo_user->userid;
		$lo_search->accountid = $pi_accountid;

		$lo_account = $this->getaccount($lo_search);

		if(!is_object($lo_account))
			return false;

		return true;
	}


}