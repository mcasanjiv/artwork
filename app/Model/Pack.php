<?php
class Pack extends AppModel {
	
	var  $packIds = array('BA'=>'Background','ST'=>'Sticker','FR'=>'Frame','FI'=>'Filter','FO'=>'Font');
	var $localLang = array('HI'=>'Hindi','GU'=>'Gugrati','MR'=>'Marathi');
	const PAGE_LIMIT =30;

	
	public function getAllPacksList($status,$params,$controller){
		$order = array('Pack.created_date'=>'DESC');
		$conditions = array('Pack.is_delete'=>false);
		$controller->paginate = array(
		 'conditions'=>$conditions,
	   	 'order' => $order,
		 'limit' =>self::PAGE_LIMIT
		);

		$data = $controller->paginate('Pack');
		$totalmembercount = $this->find('count',array('conditions'=>$conditions,'order'=>$order));
		$data['UserCount'] = $totalmembercount;
		return $data;
	}
	
		

	//gfhgfh
	
}
?>