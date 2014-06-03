<div class="admin_login_box">
<?php echo $this->Session->flash();?>
<div class="sl">Secure Login</div>
<?php  echo $this->Form->create('UsersInfo',array('inputDefaults'=>array('div'=>'lfild')));?>
<div class="login_txt_fields"><?php echo $this->Form->input('username',array('label'=>'Username<span>*</span>'));?>
<?php echo $this->Form->input('password',array('label'=>'Password<span>*</span>'));?>
</div>
<?php echo $this->Form->submit('Login');?> <?php echo $this->Form->end();?>
</div>
