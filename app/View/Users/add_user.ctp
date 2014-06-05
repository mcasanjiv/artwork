<?php echo $this->element('users_submenu')?>

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
<div class="leftbox"><?php  echo $this->Form->create('UsersInfo',array('type'=>'file'));?>
<div class="td"><?php echo $this->Form->input('username',array('class'=>'validate[required],ajax[ajaxUserCallPhp]'));?>
</div>
<div class="td"><?php echo $this->Form->input('name',array('class'=>'validate[required]'));?>
</div>
<div class="td"><?php echo $this->Form->input('email',array('class'=>'validate[required,email]'));?>
</div>
<div class="td"><?php echo $this->Form->input('password',array('class'=>'validate[required,minSize[6]]'));?>
</div>
<div class="td">
<label for="UsersInfoAddress">Address</label>
<?php echo $this->Form->textarea('address',array('label'=>'About Member','cols'=>40,'rows'=>3,'class'=>'validate[required]'));?>
</div>

<div class="td"><label for="Status">Role</label> <?php $options = array('1' => 'Admin', '2' => 'Designer');
echo $this->Form->select('role',$options,array('empty'=>false));
?></div>

<div class="td"><label for="Status">Status</label> <?php $options = array('0' => 'Inactive', '1' => 'Active');
echo $this->Form->select('status',$options,array('empty'=>false));
?></div>

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