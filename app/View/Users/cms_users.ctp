<script type="text/javascript">

$(document).ready(function(){
	$('.chk_submit').attr("disabled", "disabled");
	$('#categ').change(function(){
		
		var url = $('#cccur_url').val();
		var sortby = $('#categ').val();
		formcaturl(url,sortby);
		});
	$('#status').change(function() {
		
		var url = $('#cur_url').val();
		var sortby = $('#status').val();
		formurl(url,sortby);	
	});


	$('#srchkey').blur(function(){
		
		var check = $('#srchkey').val();
		if(check==""){
			$('#srchkey').val('Filter');
		}
	}); 
	$('#srchkey').focus(function(){
		var check1 = $('#srchkey').val();
		if(check1=="Filter"){
		$('#srchkey').val('');
		}
		else{
			$('#srchkey').val(check1);
			}
		
	});
	$('#search_form').submit(function() {
		var url = $('#srch_url').val();
		var sortby = $('#srchkey').val();
		sortby = $.trim(sortby);
		sortby = sortby.replace(/\f+/g, '-').toLowerCase();
		searchformurl(url,sortby);
		return false;
	});
	function searchformurl(url, key) {
		var key = key;
		var newurl= url.replace("{Q-KEYWORD-SEARCH}", key);
		window.location = newurl;
	}

	function formcaturl(url,sortby) {
		
		var key = sortby;
		key = 'cat_'+key;	
		
		var newurl= url.replace("cat_{S-KEYWORD-SORT}",key);
		window.location = newurl;
	}
	function formurl(url,sortby) {
		
		var key = sortby;
		key = 's_'+key;	
		
		var newurl= url.replace("s_{S-KEYWORD-SORT}",key);
		window.location = newurl;
	}
	$(function(){
		$('.parent').click(function(){
			if($(this).is(':checked')){
				$('.child').attr('checked',true);
				$('.chk_submit').removeAttr("disabled");
			}
			else
			{
				$('.child').attr('checked',false);
				$('.chk_submit').attr("disabled", "disabled");
			}
			});
		$('.child').change(function(){
			if($(this).is(':checked')){
				$('.chk_submit').removeAttr("disabled");
			}
			else
			{
				$('.chk_submit').attr("disabled", "disabled");
			}
			});
		});
	$(function(){
		});
});
</script>

<div class="listing">
<div class="listing_top">
<h3><b><?php echo $this->Paginator->counter(array('format' => 'Page %page% of %pages%, showing %current% records out of             %count% total, starting on record %start%, ending on %end%')); ?></b></h3>

	<?php echo $this->Form->create('productlist',array('url' => array('controller' => 'admin', 'action' => 'delete'),'inputDefaults'=>array('label' => false,'div'=>false)));?>
<table class="list-table" cellspacing="0" cellpadding="5" border="0">
	<tr class="list-heading">
		<!-- th><input type="checkbox" class="parent" /></th-->

		<th class="tool"><span>ID</span></th>
		<th class="tool"><span>Name</span></th>
		<th class="tool"><span>Email</span></th>
		<th class=" tool"><span>Role</span></th>
		<th class=" tool"><span>Address</span></th>
		<th class="tool"><span>Status</span></th>
		<th class="tool"><span>Created Date</span></th>
		<th class="tool"><span>Updated Date</span></th>
		<th class="tool"><span>Action</span></th>
	</tr>
	<?php
	//pr($allProduct);die;
	if(!empty($AllMembers)) {
		foreach($AllMembers as $member){?>
	<tr class="list-val">
		<td><?php echo 1 ?></td>
		<td><?php echo $member['UsersInfo']['name']; ?></td>
		<td><?php echo $member['UsersInfo']['email']; ?></td>
		<td><?php 
		if($member['UsersInfo']['role']=1)
		{
			echo 'Admin';
		}
		else
		{
			echo 'Designer';
		}
		?></td>
		<td><?php echo $member['UsersInfo']['address']; ?></td>
		<td><?php 
		if($member['UsersInfo']['status']==0)
		{
			echo 'INACTIVE';
		}
		else
		{
			echo 'ACTIVE';
		}
		?></td>
		<?php //$date=date('F j, Y',$member['Member']['created']);?>
		<td><?php echo $member['UsersInfo']['created_date']; ?></td>
		<td><?php echo $member['UsersInfo']['updated_date']; ?></td>
		<td class="tool"><?php echo $this->Html->link('Edit','userDetail/'.$member['UsersInfo']['username']);?>
		<?php echo $this->Html->link('Delete',array('action' => 'deleteUser', $member['UsersInfo']['id']),array('confirm' => 'Are you sure?'));
		unset($data);
		?> 
		</td>


	</tr>
	<?php }?>
	<?php } else { echo "<tr><td colspan='7'><h2>No Member Found</h2></td></tr>";}?>
</table>
	<?php if(!empty($AllMembers)){?>
<div class="pagination_bar"><?php
echo $this->Paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled hide'));
// Shows the page numbers
$options['separator'] = '&nbsp;';
echo $this->Paginator->numbers($options);

// Shows the next and previous links
echo $this->Paginator->next(__('Next', true), array(), null, array('class'=>'disabled hide'));



// prints X of Y, where X is current page and Y is number of pages
//echo $this->Paginator->counter();
?></div>
<?php }?></div>
<!-- div class="add-btns">
<div class="add-btns_chk"><?php
echo $this->Form->submit('Move To Trash',array('name'=>'check','class'=>'chk_submit'));
?></div>
<div class="add-btns_align"><?php $options = array('c' => 'Center', 't' => 'Top','b'=>'Bottom','r'=>'Right','l'=>'Left');
echo $this->Form->select('img_alignment',$options,array('empty'=>'Select Crop Aignment','class'=>'chk_submit'));

echo $this->Form->submit('Set Alignment',array('name'=>'checkss','class'=>'chk_submit'));
?></div>
</div-->

<?php echo $this->Form->end();?>