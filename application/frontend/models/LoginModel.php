<?
namespace Mercury\App\Frontend\Models;

use Mercury\Helper\Model;

class LoginModel extends Model {


	protected function initmodel() {

		// Set this because the table name is not in standard format
		$this->settable('user');

	}

	/**
	 * Find the user with matching email
	 * @param  string $ps_email
	 * @return object
	 */
	public function getuser($ps_email){

		if(!$this->checkemail($ps_email))
			return false;

		// Now query and get the user
		$lo_user = $this->db->getsingleobject("SELECT * FROM `user` WHERE `email` = :email", array('email' => $ps_email));

		return $lo_user;
	}

	public function updateuser($pi_userid, $pa_data){

		$this->db->dbupdate('user', 'userid', $pi_userid, $pa_data);
	}

}