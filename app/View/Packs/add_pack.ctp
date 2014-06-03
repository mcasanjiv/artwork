<?php
App::import('Model', 'Pack');
$this->UserInfo = new Pack();
?>
<script type="text/javascript">
$(document).ready(function(){
	//$(".group1").colorbox({rel:'group1'});
	$('#UsersInfoAddUserForm').validationEngine({promptPosition : 'topRight'});
});
</script>
<style type="text/css">
.td_enable {
	float: right;
}

.td_enable label {
	padding-right: 5px;
}
</style>
<div id="wrapper_product">
<div class="layout_product">
<div class="leftbox">
	<?php  echo $this->Form->create('Pack',array('type'=>'file'));?>
	
	<div class="td"><label for="Status">Type</label> 
	<?php echo $this->Form->select('role',$this->UserInfo->packIds,array('empty'=>false));?>
	</div>
	
	<div class="td"><label for="Status">Local</label> 
	<?php echo $this->Form->select('role',$this->UserInfo->localLang,array('empty'=>false));?>
	<?php  echo $this->Form->input('is_en',array('type'=>'checkbox','label'=>'EN '));?>
	</div>
	
	<div class="td"><?php echo $this->Form->input('title',array('class'=>'validate[required]'));?>
	</div>
	
	<div class="td">
	<label for="UsersInfoAddress">Description</label>
	<?php echo $this->Form->textarea('desc',array('label'=>'About Member','cols'=>40,'rows'=>3,'class'=>'validate[required]'));?>
	</div>
	
	<div class="td"><label for="Status">Local</label> 
	<?php $option = array(1=>'Yes',0=>'No');?>
	<?php echo $this->Form->select('isFree',$option,array('empty'=>false));?>
	</div>
	
	<div class="td"><?php echo $this->Form->input('price');?></div>
	
	<div class="td"><?php echo $this->Form->input('latitude');?></div>
	
	<div class="td"><?php echo $this->Form->input('longitude');?></div>
</div>

<div class="leftbox">
<label style="display: block;">Image</label>
<small>Format : .gif, .jpg, .png.</small>
<br/><br/>
	<?php  echo $this->Form->input('icon_url',array('type'=>'file','label'=>false));?>
</div>

<div class="leftbox" style="margin-top: 20px;">
<label style="display: block;">Image</label>
<small>Format : .gif, .jpg, .png.</small>
<br/><br/>
	<?php  echo $this->Form->input('detail_image_url',array('type'=>'file','label'=>false));?>
</div>

</div>

<div class="footer_product">
<?php echo $this->Form->submit('Save & Continue',array('name'=>'continue'));?>
<?php echo $this->Form->submit('Save',array('name'=>'submit'));?>
<?php echo $this->Form->button('Reset', array('type' => 'reset')); ?>
<div class="clear"></div>
 <?php echo $this->Form->end();?>
</div>
</div>