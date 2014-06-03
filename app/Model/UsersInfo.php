<?php
class UsersInfo extends AppModel {
	public  $useTable = 'usersinfo';
	
	public $USER_STATUS_ACTIVE =1;
	public $USER_STATUS_INACTIVE=0;
	public $USER_ROLE_ADMIN =1;
	public $USER_ROLE_DESIGNER=2;
	const PAGE_LIMIT =30;
	
		
public function getAllCmsUsers($status,$params,$controller){
		$order = array('UsersInfo.created_date'=>'DESC');
		$controller->paginate = array(
	   	 'order' => $order,
		 'limit' =>self::PAGE_LIMIT
		);

		$data = $controller->paginate('UsersInfo');
		$totalmembercount = $this->find('count',array('order'=>$order));
		$data['UserCount'] = $totalmembercount;
		return $data;
	}
	
	
	function memberLogo($id,$status=1){
		//$this->unbindModelAll();
		$conditions=array('Member.id'=>$id,'Member.status'=>$status);
		$member=$this->find('first',array('conditions'=>$conditions));
		return $member;
	}
	
}
?>