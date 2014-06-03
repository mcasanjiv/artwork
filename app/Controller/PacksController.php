<?php
App::import('Model', 'Pack');
class PacksController extends AppController {
	var $name = "Packs";
	var $uses = array('Pack');
	var $components = array('Auth'=>array('authorize' => 'Controller'),'RequestHandler','Session','Image');
	public $helpers = array('Html', 'Form', 'Session','Js');
	
	
	function beforeFilter() { 
			$this->layout = 'Admin';
			$this->Auth->allow('login');
	        parent::beforeFilter();
		}

	
	public function addPack() { // Pack::PAGE_LIMIT ;die;
		//pr($this->request->data);die;
		if($this->request->data) {
			$usernameValue =$this->request->data['UsersInfo']['username'];
			if(!$this->UsersInfo->findByUsername($usernameValue)){
				$this->request->data['UsersInfo']['created_date'] = date("Y-m-d H:i:s");
				$this->request->data['UsersInfo']['updated_date'] = date("Y-m-d H:i:s");
				$this->request->data['UsersInfo']['password'] = AuthComponent::password($this->request->data['UsersInfo']['password']);
				if($this->UsersInfo->save($this->request->data)){
					if(isset($this->request->data['continue'])){
						$this->Session->setFlash('User Created. Add New One.','flash_success');
						$this->redirect(array('action'=>'addUser'));
					}else{
						$this->Session->setFlash('User Created.','flash_success');
						$this->redirect(array('action'=>'cmsUsers'));
					}
				}
			}else{
				$this->Session->setFlash('Username exists, please try a different username.','flash_error');
				$this->redirect(array('action'=>'addUser'));
			}
			
		}
	}
	
	//ajax check user name
	function UsernameAvailibiltyCheck() {
		/* RECEIVE VALUE */
		$this->autoRender = false;
		$validateValue=$_REQUEST['fieldValue'];
		$validateId=$_REQUEST['fieldId'];
		$validateError= "Username exists, please try a different username.";
		$validateSuccess= "Username available for use";
		/* RETURN VALUE */
		$arrayToJs = array();
		$arrayToJs[0] = $validateId;
		$member = $this->UsersInfo->find('first',array('conditions'=>array('UsersInfo.username'=>$validateValue)));
		$this->RequestHandler->setContent('json', 'application/json');
		Configure::write('debug', 0);
		if(!$member){
			$arrayToJs[1] = true;			// RETURN TRUE
			echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
		}else {
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
	
	
	public function userDetail($username=null){
		
		if(empty($username))$username= CakeSession::read('Auth.User.username');
		$member=$this->UsersInfo->find('first',array('conditions'=>array('UsersInfo.username'=>$username)));
		if (!$member) {
	        throw new NotFoundException(__('Invalid User'));
	    }
	    
	    $this->UsersInfo->id = $member['UsersInfo']['id'];
	    
	    if(!empty($this->request->data['UsersInfo'])) {
	    	$this->request->data['UsersInfo']['updated_date'] = date("Y-m-d H:i:s");
	    	$this->UsersInfo->save($this->request->data);
	    	$this->Session->setFlash($username.' Details Updated','flash_success');
	    	$this->redirect(array('action'=>'cmsUsers'));
	    }
	    $this->request->data = $this->UsersInfo->read();
		
		
	}
	
	function resetPassword($username) {
		$member=$this->UsersInfo->find('first',array('conditions'=>array('UsersInfo.username'=>$username)));
		if (!$member) {
	        throw new NotFoundException(__('Invalid User'));
	    }
	    
	    $this->UsersInfo->id = $member['UsersInfo']['id'];
		if($this->request->data) {
				$this->request->data['UsersInfo']['updated_date'] = date("Y-m-d H:i:s");
				$this->request->data['UsersInfo']['password']=Security::hash($this->request->data['UsersInfo']['password'], null, true);
				if($this->UsersInfo->save($this->request->data)) {
					$this->Session->setFlash('Password has been changed','flash_success');
			}else {
				$this->Session->setFlash('You are not able to change!','flash_error');
			}
			$this->redirect(array('action'=>'userDetail',$username));
		}
	}
	
	function cmsUsers(){
		$params = $this->params['named'];
		
		$AllMembers=$this->UsersInfo->getAllCmsUsers($this->UsersInfo->USER_ROLE_ADMIN,$params,$this);
		$membercount=$AllMembers['UserCount'];
		$this->set('membercount',$membercount);
		unset($AllMembers['UserCount']);
		$this->set('AllMembers',$AllMembers);
	}
	
	public function deleteUser($id) {
			if($this->UsersInfo->deleteAll(array('UsersInfo.id'=>$id)))
			{
				$this->Session->setFlash('The CMS User with id: '.$id .' has been deleted.','flash_success');
				$this->redirect($this->referer());
			}
	}
	
	
}
