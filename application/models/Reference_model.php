<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Reference_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('main_lib');
		$this->load->library('session');
	}

	/* start evenodd*/

	//valid user login
	function valid_user($username, $password)
	{
		// echo(sha1($password));
		// die;
		$this->db->select('u.*');
		$this->db->from('tbl_user as u');
		$this->db->where('user_login', $username);
		$this->db->where('user_password', sha1($password));
		$query = $this->db->get();
		return $query->row_array();
	}

	//function to manage session login status
	public function setSession($userId, $sessionId)
	{
		//get previous mapped session id
		$this->db->select('session_id');
		$this->db->from('tbl_user');
		$this->db->where('user_id', $userId);
		$oldSessionId = $this->db->get()->row()->session_id;
		//distroy session which was mapped to previous user
		$this->db->where('id', $oldSessionId);
		$this->db->delete('ci_sessions');
		//Map new session Id to the user
		//echo($sessionId);die;
		date_default_timezone_set('Asia/Kolkata');
		$current_date = date('Y-m-d');
		$current_time = date('h:i:s');
		$this->db->where('user_id', $userId);
		$this->db->update('tbl_user', array('session_id' => $sessionId, 'user_login_date' => $current_date, 'user_login_time' => $current_time, 'login_status' => '1'));
	}

	//create new user
	function create_user()
	{
		//print_r($_POST);die;
		$childUserType = 0;
		$userId = trim($this->input->post('userParrent'));
		$userType = $this->getUserType($userId);
		if ($userType == 1) {
			$childUserType = 3;
		} else {
			$childUserType = intval($userType) + 1;
		}
		$userContact = $this->input->post('userContact');
		if( $userContact == null){
			$userContact == 0;
		}
		$userCommission = $this->input->post('userCommission');
		if( $userCommission == null){
			$userCommission == 0;
		}
		
		$userArray = array(
			'user_name' => ucwords(trim($this->input->post('userName'))),
			'user_contact' => trim($userContact),
			'user_type' => $childUserType,
			'user_login' => trim($this->input->post('userLogin')),
			'user_password' => sha1(trim($this->input->post('userPassword'))),
			'user_parent' => trim($this->input->post('userParrent')),
			'user_commission' => trim($userCommission)
		);
		$this->db->insert('tbl_user', $userArray);
		$insert_id = $this->db->insert_id();
		$result = $this->db->get_where("tbl_user", array('user_id' => $insert_id));
		//print_r ($result->row_array());die;
		return $result->row_array();
	}
	function getAllUsersByParents($userType, $parentId)
	{

		$ResultArray = array();
		if ($userType == 1) {
			$sd = $this->get_users_byParent($userType, $parentId);
			if (!empty($sd)) {
				foreach ($sd as $parentSD) {
					array_push($ResultArray, $parentSD);					
					$d = $this->get_users_byParent($userType, $parentSD['user_id']);
					if (!empty($d)) {
						$DArray = $d;
						foreach ($d as $parentD) {
							array_push($ResultArray, $parentSD);
							$r = $this->get_users_byParent($userType, $parentD['user_id']);
							foreach ($r as $retailer) {
								array_push($ResultArray, $retailer);
							}
						}
					}
				}
			}
			//			$ResultArray = array_merge($SDArray, $DArray, $RArray);
		} else if ($userType == 3) {
			$d = $this->get_users_byParent($userType, $parentId);
			if (!empty($d)) {
				$DArray = $d;
				foreach ($d as $parentD) {
					array_push($ResultArray, $parentD);
					$r = $this->get_users_byParent($userType, $parentD['user_id']);
					foreach ($r as $retailer) {
						array_push($ResultArray, $retailer);
					}
				}
			}
			//	$ResultArray = array_merge($DArray, $RArray);
		} else {
			$ResultArray = $this->get_users_byParent($userType, $parentId);
		}
		return $ResultArray;
//		echo "<pre>";
//			print_r($ResultArray);die;
		//		print_r($resultData);die;
	}
	function get_users_byParent($userType, $parentId)
	{
		$resultData = array();
		$temp = array();
		$this->db->where('user_type >', $userType);
		$this->db->where('user_parent', $parentId);
		$this->db->order_by('user_id', 'desc');
		$query = $this->db->get('tbl_user');
		$queryResult = $query->result_array();
		if (!empty($queryResult)) {
			foreach ($queryResult as $qrs) {
				$qrs['points'] = $this->Points_model->get_points(($qrs['user_id']));
				array_push($resultData, $qrs);
			}
		}
		return $resultData;
		//	$query->result_array();
		//echo $this->db->last_query();die;
		print_r($resultData);
		die;
	}


	function get_retailers_byParent($userType, $parentId)
	{
		$this->db->where('user_type', '5');
		if ($userType != '1') {
			$this->db->where('user_parent', $parentId);
		}
		$this->db->order_by('user_type', 'desc');
		$query = $this->db->get('tbl_user');
		return $query->result_array();
	}
	function get_retailersId_byParent($userType, $parentId)
	{
		$retailerArray = array();
		if ($userType == '3') {
			//echo "inside";
			$this->db->select('user_id');
			$query = $this->db->get_where('tbl_user', array('user_parent' => $parentId));
			$distributors = $query->result_array();
			foreach ($distributors as $distributor) {
				$this->db->select('user_id');
				$this->db->where('user_type', '5');
				//$this->db->where('login_status', '1');
				$this->db->where('user_parent', $distributor['user_id']);
				$query = $this->db->get('tbl_user');
				$queryArray = $query->result_array();
				if (!empty($queryArray)) {
					if (empty($retailerArray)) {
						$retailerArray = $queryArray;
					} else {
						array_merge($retailerArray, $queryArray);
					}
				}
			}
		} else {
			//	echo "outside";
			$this->db->select('user_id');
			$this->db->where('user_type', '5');
			//$this->db->where('login_status', '1');
			$this->db->where('user_parent', $parentId);
			$query = $this->db->get('tbl_user');
			$retailerArray = $query->result_array();
		}
		//		echo "<pre>";
		//		print_r($retailerArray);die;
		return $retailerArray;
	}
	function get_live_retailers_byParent($userType, $parentId)
	{
		date_default_timezone_set('Asia/Kolkata');
		$current_date = date('Y-m-d');
		$current_time = date('h:i:s');
		$this->db->where('user_type', '5');
		if ($userType != '1') {
			$this->db->where('user_parent', $parentId);
		}
		$this->db->where('user_login_date', $current_date);
		$this->db->where('user_login_time <=', $current_time);
		$this->db->where('login_status', '1');
		$this->db->order_by('user_type', 'desc');
		$query = $this->db->get('tbl_user');
		$result = $query->result_array();
		$finalResult = array();
		foreach ($result as $res) {
			$points = $this->Points_model->get_points($res['user_id']);
			$newData = array('points' => $points);
			$mergedRows = array_merge($res, $newData);
			array_push($finalResult, $mergedRows);
		}
		//  print_r($finalResult);die; 
		//print_r($query->result_array());die; 
		return $finalResult;
	}

	function get_parent_users_byType($userType)
	{
		$this->db->select("user_id, user_name");
		$this->db->where('user_type', $userType);
		$query = $this->db->get('tbl_user');
		return $query->result_array();
	}

	function edit_user($id)
	{
		$this->db->where('user_id', $id);
		$this->db->limit(1);
		$result = $this->db->get('tbl_user');
		return $result->row_array();
	}

	// to update edited user
	function update_user($data, $id)
	{
		$this->db->where('user_id', $id);
		$result = $this->db->update('tbl_user', $data);
		return $result;
	}

	// to update Login Password
	function update_password($data, $id)
	{
		$this->db->where('user_id', $id);
		$result = $this->db->update('tbl_user', array('user_password' => $data));
		return $result;
	}

	//deactivate holdon users
	function user_deactivate($id)
	{
		$userIds = array();
		$distributors = array();
		$allIds = array();
		$userType = $this->getUserType($id);
		if ($userType == 3) {
			$userIds = $this->get_retailersId_byParent($userType, $id);
			$counter = 0;
			foreach ($userIds as $userId) {
				$allIds[$counter] = $userId['user_id'];
				$counter++;
			}
			$distributors = $this->get_usersIds_byParent($userType, $id);
			foreach ($distributors as $distributor) {
				$allIds[$counter] = $distributor['user_id'];
				$counter++;
			}
		} else {
			$userIds = $this->get_retailersId_byParent($userType, $id);
			$counter = 0;
			foreach ($userIds as $userId) {
				$allIds[$counter] = $userId['user_id'];
				$counter++;
			}
		}
		$allIds[$counter] = $id;
		$this->db->where_in('user_id', $allIds);
		$result = $this->db->update('tbl_user', array('user_enable' => false));
		return $result;
	}
	//active existring users
	function user_activate($id)
	{
		$userIds = array();
		$distributors = array();
		$allIds = array();
		$userType = $this->getUserType($id);
		if ($userType == 3) {
			$userIds = $this->get_retailersId_byParent($userType, $id);
			$counter = 0;
			foreach ($userIds as $userId) {
				$allIds[$counter] = $userId['user_id'];
				$counter++;
			}
			$distributors = $this->get_usersIds_byParent($userType, $id);
			foreach ($distributors as $distributor) {
				$allIds[$counter] = $distributor['user_id'];
				$counter++;
			}
		} else {
			$userIds = $this->get_retailersId_byParent($userType, $id);
			$counter = 0;
			foreach ($userIds as $userId) {
				$allIds[$counter] = $userId['user_id'];
				$counter++;
			}
		}
		$allIds[$counter] = $id;
		//print_r($userIds); die;
		$this->db->where_in('user_id', $allIds);
		$result = $this->db->update('tbl_user', array('user_enable' => true));
		return $result;
	}
	//remove left users
	function delete_user($id)
	{
		$query = $this->db->get_where('tbl_user',array('user_parent' => $id));
		$resultData = $query->result_array();
		//print_r($resultData);die;
		if(empty($resultData)){
			$this->db->where('user_id', $id);
			$result = $this->db->delete('tbl_user');
			return $result;
		}else{
			return "";
		}

	}




	/* end evenodd*/
	function getLastUserId()
	{
		$this->db->select('user_id');
		$this->db->order_by('user_id', 'desc');
		$this->db->limit(1);
		$this->db->from('tbl_user');
		return $this->db->get()->row()->user_id;
	}
	function getUserByLoginId($userLoginId)
	{
		$query = $this->db->get_where('tbl_user', array('user_login' => $userLoginId));
		$user = $query->row_array();
	//	print_r($user);
		if(empty($user))
			return 0;
		else
			return 1;
	}
	function getUserByLogin_Id($userLoginId)
	{
		$query = $this->db->get_where('tbl_user', array('user_login' => $userLoginId));
		return $query->row_array();
	}

	//get user Designations
	function get_designations()
	{
		$query = $this->db->get('role');
		return $query->result_array();
	}
	function get_designation($id)
	{
		$this->db->where('roleId', $id);
		$this->db->limit(1);
		$query = $this->db->get('role');
		return $query->row_array();
	}

	//get user by id
	function get_user($id)
	{
		$this->db->where('user_id', $id);
		$query = $this->db->get('tbl_user');
		return $query->row_array();
	}

	//get all users
	function get_all_user()
	{
		$this->db->where('user_type !=', '1');
		$query = $this->db->get('tbl_user');
		return $query->result_array();
	}

	function logoutUser($userId)
	{
		$this->db->where('user_id', $userId);
		$this->db->update('tbl_user', array('login_status' => 0, 'session_id' => ""));
	}

	//get user financial details like winning, commmission, points etc
	function getUserFinancials($userId, $fromDate, $toDate)
	{
		$userType = $this->session->userdata('userType');
		$retailers = $this->get_retailers_byParent($userType, $userId);
		$reportData = array();
		foreach ($retailers as $retailer) {
			$commission = $this->Points_model->getAllCommissionTotal($retailer['user_id'], $fromDate, $toDate);
			$winPoints = $this->Result_model->getAllWinTotal($retailer['user_id'], $fromDate, $toDate);
			/* 	$fPiece = explode("-",$fromDate);
			$fromDate = $fPiece[2]."-".$fPiece[1]."-".$fPiece[0];
			$tPiece = explode("-",$toDate);
			$toDate = $tPiece[2]."-".$tPiece[1]."-".$tPiece[0]; */
			//			echo $toDate;
			$PlayPoints = $this->Ticket_model->getAllPlayedTotal($retailer['user_id'], $fromDate, $toDate);
			//echo $PlayPoints;die;
			$newArray = array();
			$newArray = array(
				'user_id' => $retailer['user_id'],
				'user_name' => $retailer['user_login'],
				'totalPoints' => $PlayPoints,
				'totalCommission' =>  $commission,
				'totalWinnings' => $winPoints
			);
			array_push($reportData, $newArray);
		}
		return $reportData;
	}
	function getUserFinancialsAtAdmin($userId, $userType, $fromDate, $toDate, $drawTime = "")
	{
		//		echo "draw: {$drawTime}";
		$sdData = array();
		$dData = array();
		$retailers = array();
		$commission = 0;
		$winPoints = 0;
		$winNCPoints = 0;
		$PlayPoints = 0;
		$cdPlayPoints = 0;
		$newArray = array();
		$reportData = array();
		if ($userType == 1) {
			$sdData = $this->get_users_byParent($userType, $userId);
			foreach ($sdData as $sd) {
				$commission = 0;
				$winPoints = 0;
				$winNCPoints = 0;
				$PlayPoints = 0;
				$cdPlayPoints = 0;
				$commission += floatval($this->Points_model->getAllCommissionTotal($sd['user_id'], $fromDate, $toDate));

				$dData = $this->get_users_byParent($sd['user_type'], $sd['user_id']);
				foreach ($dData as $dd) {
					$commission += floatval($this->Points_model->getAllCommissionTotal($dd['user_id'], $fromDate, $toDate));
					$retailers = $this->get_users_byParent($dd['user_type'], $dd['user_id']);
					foreach ($retailers as $retailer) {
						$commission += floatval($this->Points_model->getAllCommissionTotal($retailer['user_id'], $fromDate, $toDate));
						$winPoints += floatval($this->Result_model->getAllWinTotal($retailer['user_id'], $fromDate, $toDate));
						$winNCPoints += floatval($this->Result_model->getAllWinPendingTotal($retailer['user_id'], $fromDate));
						$PlayPoints += floatval($this->Ticket_model->getAllPlayedTotal($retailer['user_id'], $fromDate, $toDate));
						$cdPlayPoints += floatval($this->Ticket_model->getAllPlayedCDTotal($retailer['user_id'], $toDate, $drawTime));
					}
				}

				$newArray = array();
				$newArray = array(
					'user_id' => $sd['user_id'],
					'user_name' => $sd['user_login'],
					'user_type' => $sd['user_type'],
					'totalPoints' => $PlayPoints,
					'totalCommission' =>  $commission,
					'totalWinnings' => $winPoints,
					'totalPending' => $winNCPoints,
					'totalCdPlayed' => $cdPlayPoints
				);
				//echo $winPoints;
				array_push($reportData, $newArray);
			}
			//	die;
			// echo "<pre>";
			// print_r($reportData);
			// echo "</pre>";
		} else if ($userType == 3) {
			$dData = $this->get_users_byParent($userType, $userId);
			foreach ($dData as $dd) {
				$commission = 0;
				$winPoints = 0;
				$winNCPoints = 0;
				$PlayPoints = 0;
				$cdPlayPoints = 0;
				$commission += floatval($this->Points_model->getAllCommissionTotal($dd['user_id'], $fromDate, $toDate));
				$retailers = $this->get_users_byParent($dd['user_type'], $dd['user_id']);
				foreach ($retailers as $retailer) {
					$commission += floatval($this->Points_model->getAllCommissionTotal($retailer['user_id'], $fromDate, $toDate));
					$winPoints += floatval($this->Result_model->getAllWinTotal($retailer['user_id'], $fromDate, $toDate));
					$winNCPoints += floatval($this->Result_model->getAllWinPendingTotal($retailer['user_id'], $fromDate));
					$PlayPoints += floatval($this->Ticket_model->getAllPlayedTotal($retailer['user_id'], $fromDate, $toDate));
					$cdPlayPoints += floatval($this->Ticket_model->getAllPlayedCDTotal($retailer['user_id'], $toDate, $drawTime));
				}
				$newArray = array();

				$newArray = array(
					'user_id' => $dd['user_id'],
					'user_name' => $dd['user_login'],
					'user_type' => $dd['user_type'],
					'totalPoints' => $PlayPoints,
					'totalCommission' =>  $commission,
					'totalWinnings' => $winPoints,
					'totalPending' => $winNCPoints,
					'totalCdPlayed' => $cdPlayPoints
				);
				array_push($reportData, $newArray);
			}
		} else if ($userType == 4) {
			$retailers = $this->get_users_byParent($userType, $userId);
			foreach ($retailers as $retailer) {
				$commission = floatval($this->Points_model->getAllCommissionTotal($retailer['user_id'], $fromDate, $toDate));
				$winPoints = floatval($this->Result_model->getAllWinTotal($retailer['user_id'], $fromDate, $toDate));
				$winNCPoints += floatval($this->Result_model->getAllWinPendingTotal($retailer['user_id'], $fromDate));
				$PlayPoints = floatval($this->Ticket_model->getAllPlayedTotal($retailer['user_id'], $fromDate, $toDate));
				$cdPlayPoints += floatval($this->Ticket_model->getAllPlayedCDTotal($retailer['user_id'], $toDate, $drawTime));
				$newArray = array();

				$newArray = array(
					'user_id' => $retailer['user_id'],
					'user_name' => $retailer['user_login'],
					'user_type' => $retailer['user_type'],
					'totalPoints' => $PlayPoints,
					'totalCommission' =>  $commission,
					'totalWinnings' => $winPoints,
					'totalPending' => $winNCPoints,
					'totalCdPlayed' => $cdPlayPoints
				);
				array_push($reportData, $newArray);
			}
		} else if ($userType == 5) {
			$commission = floatval($this->Points_model->getAllCommissionTotal($userId, $fromDate, $toDate));
			$winPoints = floatval($this->Result_model->getAllWinTotal($userId, $fromDate, $toDate));
			$winNCPoints = floatval($this->Result_model->getAllWinPendingTotal($userId, $fromDate));
			$PlayPoints = floatval($this->Ticket_model->getAllPlayedTotal($userId, $fromDate, $toDate));
			$cdPlayPoints += floatval($this->Ticket_model->getAllPlayedCDTotal($userId, $toDate, $drawTime));
			$retailer = $this->edit_user($userId);
			if (!empty($retailer)) {
				$newArray = array(
					'user_id' => $userId,
					'user_name' => $retailer['user_login'],
					'user_type' => $userType,
					'totalPoints' => $PlayPoints,
					'totalCommission' =>  $commission,
					'totalWinnings' => $winPoints,
					'totalPending' => $winNCPoints,
					'totalCdPlayed' => $cdPlayPoints
				);
				array_push($reportData, $newArray);
			}
		}
		return $reportData;
	}

	function get_users_byType($userType)
	{
		$matchArray = array(
			'user_type' => $userType,
			'user_status' => '1',
		);
		$this->db->select('user_id , user_name, user_login, user_type');
		$query = $this->db->get_where('tbl_user', $matchArray);
		return $query->result_array();
	}

	function getUserType($id)
	{
		$this->db->select('user_type');
		$this->db->where('user_id', $id);
		$this->db->limit(1);
		$this->db->from('tbl_user');
		return $this->db->get()->row()->user_type;
	}
	function get_usersIds_byParent($userType, $parentId)
	{
		$this->db->select('user_id');
		$this->db->where('user_type >', $userType);
		$this->db->where('user_parent', $parentId);
		$this->db->order_by('user_id', 'desc');
		$query = $this->db->get('tbl_user');
		return $query->result_array();
	}

	//Disable enable all users
	function updateUserLogins($status)
	{
		$this->db->where('user_type !=', '1');
		$this->db->update('tbl_user', array('session_id' => "", 'login_status' => '0', 'user_enable' => $status));
	}
	function getEnabledUserCount()
	{
		$this->db->select("sum(user_enable) as ec");
		$this->db->from('tbl_user');
		return $this->db->get()->row()->ec;
	}
}
