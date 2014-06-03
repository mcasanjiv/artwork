<script type="text/javascript">
$(document).ready(function(){
	$('#main_navigation li').mouseover(function(){
		$(this).children('.sub-nav').show();
	});
	$('#main_navigation li').mouseout(function(){
		$(this).children('.sub-nav').hide();
	});
});
</script>
<div class="admin_header">
<div class="admin_main_menu_box">
<ul id="main_navigation">
	<li><?php echo $this->Html->link('Manage Artwork',array('controller'=>'Packs','action'=>'addPack'))?></li>
	<li><?php echo $this->Html->link('Publish Artwork','productlist')?></li>
	<li><?php echo $this->Html->link('Application User','category')?> <!--<ul class="sub-nav">
					<li><?php echo $this->Html->link('Sub Category','subcategory')?></li>
					<li><?php echo $this->Html->link('View Url','viewurl')?></li>
					<li><?php echo $this->Html->link('Add Url','url')?></li>
				</ul>
			--></li>
	<?php
	 App::import('Model', 'UsersInfo');
    $this->UserInfo = new UsersInfo();
	if(CakeSession::read('Auth.User.role')==$this->UserInfo->USER_ROLE_ADMIN){
	?>
	<li><?php echo $this->Html->link('CMS User',array('controller'=>'Users','action'=>'cmsUsers'))?>
		<ul class="sub-nav">
			<li><?php echo $this->Html->link('User List',array('controller'=>'Users','action'=>'cmsUsers'))?></li>
			<li><?php echo $this->Html->link('Add User',array('controller'=>'Users','action'=>'addUser'))?></li>
		</ul>
	</li>
	<?php }?>
</ul>
<ul id="right_nav">
	<li><span class="uname"><?php echo $this->Session->read('Auth.User.name');?></span></li>
	<li><?php echo $this->Html->link('Log Out',array('controller'=>'Users','action'=>'logout'));?></li>
</ul>
<div class="clear"></div>
</div>
</div>
