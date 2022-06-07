<?php
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$prefix = '';
if($this->request->getParam('prefix')) $prefix = DS . Inflector::camelize($this->request->getParam('prefix'));

$file = ROOT . DS . 'templates' . $prefix . DS . 'layout' . DS . 'login.php';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $this->fetch('title'); ?></title>
	
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php 
		echo $this->Html->css('AdminLTE./plugins/fontawesome-free/css/all.min.css');
		echo $this->Html->css('AdminLTE./plugins/icheck-bootstrap/icheck-bootstrap.min.css');
		echo $this->Html->css('AdminLTE.adminlte.min');
		echo $this->Html->css('AdminLTE.cake4adminlte');
		
		echo $this->fetch('css');
		
		echo $this->Html->css('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');
	?>
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<?php echo $this->fetch('content'); ?>
  	</div>
	
<?php 
	echo $this->Html->script('AdminLTE./plugins/jquery/jquery.min.js');
	echo $this->Html->script('AdminLTE./plugins/bootstrap/js/bootstrap.bundle.min.js');
	echo $this->Html->script('AdminLTE./js/adminlte.js');
?>

<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('scriptBottom'); ?>

</body>
</html>
<?php } ?>
