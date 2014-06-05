<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'ArtWork');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $cakeDescription ?>: <?php echo $title_for_layout; ?>
</title>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<?php
echo $this->Html->meta('icon');

echo $this->Html->css('admin');
echo $this->Html->css('base');
echo $this->Html->css('jvalidatecss/validationEngine.jquery.css');
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
echo $this->Html->script('jquery-1.8.2.min.js');
echo $this->Html->script('custom.js');
//echo $this->Html->script('jquery.colorbox.js');
echo $this->Html->script('jquery.validationEngine.js');
echo $this->Html->script('jquery.validationEngine-en.js');

?>
<link rel="stylesheet"
	href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<link type="text/css"
 href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/ui-lightness/jquery-ui.css"
 rel="stylesheet" />
<!--script type="text/javascript"
 src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script-->
 

<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
</head>
<body>
<div id="container">
<div id="header"><?php echo $this->element('admin_header');?></div>
<div id="content"><?php echo $this->Session->flash(); ?> <?php echo $this->fetch('content'); ?>
</div>
<div id="footer"><?php echo $this->element('admin_footer');?></div>
</div>
<?php //echo $this->element('sql_dump'); ?>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
