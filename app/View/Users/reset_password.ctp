<script type="text/javascript">
$(document).ready(function(){
	$('#UsersInfoResetPasswordForm').validationEngine({promptPosition : 'topRight'});
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
<?php //pr($this->params['pass'][0])?>
<div id="wrapper_product">
<div class="layout_product">
<div class="leftbox"><?php  echo $this->Form->create('UsersInfo');?>

	<div class="td"><?php echo $this->Form->input('password',array('class'=>'validate[required,minSize[6]]','id'=>'UserPassword'));?>
	</div>
	<div class="td"><?php echo $this->Form->input('repeatPassword',array('class'=>'validate[required,minSize[6],equals[UserPassword]]','id'=>'vpassword','type'=>'password'));?>
	</div>

</div>
</div>
<div class="footer_product"><?php echo $this->Form->submit('Update');?> <?php echo $this->Form->end();?>
<span class="link-button"><?php echo $this->Html->link('Cancel','userDetail/'.$this->params['pass'][0]) ?></span>
</div>
</div>
