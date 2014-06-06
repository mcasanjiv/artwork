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

	
	public function addPack() { // Pack::PAGE_LIMIT ;die;+
		if($this->request->data) { 
			$this->request->data['Pack']['userinfo_id'] = $this->Session->read('Auth.User.id');
			$type = $this->request->data['Pack']['type'];
			
			$lastPAckData = $this->Pack->find('first',array('conditions'=>array('Pack.type'=>$type),'order'=>array('Pack.id'=>'DESC'),'limit'=>'1'));
			if(!$lastPAckData){
				$lastId = $type. 1;
			}else{
				$nextid = substr($lastPAckData['Pack']['pack_id'],2)+1;
				$lastId = $type.$nextid;
			}
			$this->request->data['Pack']['pack_id'] = $lastId;
			
			if(!empty($this->request->data['Pack']['Image']['name'])){
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/big',false);
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/small',false);
				if (is_uploaded_file($this->request->data['Pack']['Image']['tmp_name']))	{
				    	$p=time();
					$imagename = 'icon_'.$p.'_'.$this->request->data['Pack']['Image']['name'];
					$destpath= $_SERVER['DOCUMENT_ROOT'] ."/artwork/app/webroot/img/packIcon/$imagename";
					$imname=$this->Image->upload_image_and_thumbnail($this->request->data['Pack']['Image'],298,99,'packIcon',true,'icon_'.$p.'_');
					move_uploaded_file($this->request->data['Pack']['Image']['tmp_name'],$destpath);
					$this->request->data['Pack']['icon_url'] = $imagename;
				}else{
		     	$this->request->data['Pack']['icon_url'] = '';
		     	}
		     }
		    
		     if(!empty($this->request->data['Pack']['Detail_Image']['name'])){
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/big',false);
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/small',false);
				if (is_uploaded_file($this->request->data['Pack']['Detail_Image']['tmp_name']))	{
				    	$p=time();
					$imagename = 'icon_'.$p.'_'.$this->request->data['Pack']['Detail_Image']['name'];
					$destpath= $_SERVER['DOCUMENT_ROOT'] ."/artwork/app/webroot/img/packImage/$imagename";
					$imname=$this->Image->upload_image_and_thumbnail($this->request->data['Pack']['Detail_Image'],298,99,'packImage',true,'icon_'.$p.'_');
					move_uploaded_file($this->request->data['Pack']['Detail_Image']['tmp_name'],$destpath);
					$this->request->data['Pack']['detail_image_url'] = $imagename;
				}else{
					$this->request->data['Pack']['detail_image_url'] = '';
				}
		    }
		    
			if(!empty($lastId)) { 
				$this->request->data['Pack']['created_date'] = date("Y-m-d H:i:s");
				$this->request->data['Pack']['updated_date'] = date("Y-m-d H:i:s");
				//pr($this->request->data);die;
				if($this->Pack->save($this->request->data)){
					if(isset($this->request->data['continue'])){
						$this->Session->setFlash('New Pack created. Add another.','flash_success');
						$this->redirect(array('action'=>'addPack'));
					}else{
						$this->Session->setFlash('New Pack created.','flash_success');
						$this->redirect(array('action'=>'managePack'));
					}
				}else{
					$this->Session->setFlash('Pack did not create. Please try again!!.','flash_error');
					$this->redirect(array('action'=>'addUser'));
				}
			}
			
		}
		
	}
	
	public function editPack($packid) { // Pack::PAGE_LIMIT ;die;+
		$pack=$this->Pack->find('first',array('conditions'=>array('Pack.pack_id'=>$packid)));
		if (!$pack) {
	        throw new NotFoundException(__('Invalid Pack Id'));
	    }
		$this->Pack->id = $pack['Pack']['id'];
		//pr($this->request->data);die;
		if($this->request->data) { 
			if(!empty($this->request->data['Pack']['Image']['name'])){
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/big',false);
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/small',false);
				if (is_uploaded_file($this->request->data['Pack']['Image']['tmp_name']))	{
				    	$p=time();
					$imagename = 'icon_'.$p.'_'.$this->request->data['Pack']['Image']['name'];
					$destpath= $_SERVER['DOCUMENT_ROOT'] ."/artwork/app/webroot/img/packIcon/$imagename";
					$imname=$this->Image->upload_image_and_thumbnail($this->request->data['Pack']['Image'],298,99,'packIcon',true,'icon_'.$p.'_');
					move_uploaded_file($this->request->data['Pack']['Image']['tmp_name'],$destpath);
					$this->request->data['Pack']['icon_url'] = $imagename;
				}
		     	else{
		     		$this->request->data['Pack']['icon_url'] = '';
		     	}
		 	}
		    
			 if(!empty($this->request->data['Pack']['Detail_Image']['name'])){
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/big',false);
		    	//$this->admin_removeimage($this->Member->id,$this->request->data['UsersInfo']['icon_url'],'profile/small',false);
				if (is_uploaded_file($this->request->data['Pack']['Detail_Image']['tmp_name']))	{
				    	$p=time();
					$imagename = 'icon_'.$p.'_'.$this->request->data['Pack']['Detail_Image']['name'];
					$destpath= $_SERVER['DOCUMENT_ROOT'] ."/artwork/app/webroot/img/packImage/$imagename";
					$imname=$this->Image->upload_image_and_thumbnail($this->request->data['Pack']['Detail_Image'],298,99,'packImage',true,'icon_'.$p.'_');
					move_uploaded_file($this->request->data['Pack']['Detail_Image']['tmp_name'],$destpath);
					$this->request->data['Pack']['detail_image_url'] = $imagename;
				}else{
					$this->request->data['Pack']['detail_image_url'] = '';
				}
		    }
		    
			if(!empty($this->Pack->id)) { 
				$this->request->data['Pack']['updated_date'] = date("Y-m-d H:i:s");
				if($this->Pack->save($this->request->data)){
					if(isset($this->request->data['continue'])){
						$this->Session->setFlash('This pack is updated.','flash_success');
					}else{
						$this->Session->setFlash('This pack is updated.','flash_success');
						$this->redirect(array('action'=>'managePack'));
					}
				}else{
					$this->Session->setFlash('Pack did not update. Please try again!!.','flash_error');
					$this->redirect(array('action'=>'packList'));
				}
			}
			
		}
		
		$this->request->data = $this->Pack->read();
		
	}
	
	public function removememimage($id){
			$this->autoRender=false;
			$logo=$this->Pack->findById($id);
			$imgname='';
				if(!empty($logo['Pack']['logo'])){
				$imgname=$logo['Pack']['logo'];
				}
			if(!empty($id) && !empty($imgname)){
				$folderName='packIcon/big';
				$file = new File(WWW_ROOT.'img/'.$folderName."/".$imgname);
				$file->delete();
				$folderName='packIcon/small';
				$file1 = new File(WWW_ROOT.'img/'.$folderName."/".$imgname);
				$file1->delete();
				$this->Pack->id=$id;
				$data['Pack']['icon_url']='';
				$this->Pack->save($data);
				$this->redirect($this->referer());
			}
			
		}
	
	
	function packsList(){
		$params = $this->params['named'];
		
		$AllMembers=$this->Pack->getAllPacksList(0,$params,$this);
		$membercount=$AllMembers['UserCount'];
		$this->set('membercount',$membercount);
		unset($AllMembers['UserCount']);
		$this->set('AllMembers',$AllMembers);
	}
	
	public function deletePack($id) {
			$this->Pack->id = $id;
			
			if($this->Pack->update(array('Pack.is_delete'=>true)))
			{
				$this->Session->setFlash('The Pack with id: '.$id .' has been deleted.','flash_success');
				$this->redirect($this->referer());
			}
	}
	
	
}
