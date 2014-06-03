<script type="text/javascript">
$(document).ready(function(){
	$('#UsersInfoUserDetailForm').validationEngine({promptPosition : 'topRight'});
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
<?php  echo $this->Form->create('UsersInfo',array('type'=>'file'));?>
<div class="td"><?php echo $this->Form->input('username',array('class'=>'validate[required]','disabled' => 'disabled'));?>
</div>
<div class="td"><?php echo $this->Form->input('name',array('class'=>'validate[required]','disabled' => 'disabled'));?>
</div>
<div class="td"><?php echo $this->Form->input('email',array('class'=>'validate[required,email]','disabled' => 'disabled'));?>
</div>

<div class="td">
<label for="UsersInfoAddress">Address</label>
<?php echo $this->Form->textarea('address',array('label'=>'About Member','cols'=>40,'rows'=>5,'class'=>'validate[required]','disabled' => 'disabled'));?>
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
<?php echo $this->Form->submit('Edit');?> <?php echo $this->Form->end();?>
<span class="link-button"><?php echo $this->Html->link('Reset Password','resetPassword/'.$this->params['pass'][0]) ?></span>
</div>
</div>
