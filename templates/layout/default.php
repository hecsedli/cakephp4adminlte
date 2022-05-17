<?php
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$prefix = DS . Inflector::camelize($this->request->getParam('prefix'));

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . $prefix . DS . 'Layout' . DS . 'default.ctp';

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
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo Configure::read('Theme.title'); ?></title>
	
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php 
		echo $this->Html->css('AdminLTE./plugins/fontawesome-free/css/all.min.css');
		echo $this->Html->css('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
		echo $this->Html->css('AdminLTE.adminlte.min');
		echo $this->Html->css('AdminLTE.cake3adminlte');
		
		echo $this->fetch('css');
		
		echo $this->Html->css('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
	?>
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <!-- Site wrapper -->
    <div class="wrapper">
		<?php echo $this->element('nav-top') ?>

        <?php echo $this->element('aside-main-sidebar'); ?>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Flash->render('auth'); ?>
            <?php echo $this->fetch('content'); ?>

        </div>
        <!-- /.content-wrapper -->

        <?php echo $this->element('footer'); ?>
        
        <?php echo $this->element('aside-control-sidebar'); ?>
	
	</div>
	<!-- ./wrapper -->



<?php 
	echo $this->Html->script('AdminLTE./plugins/jquery/jquery.min.js');
	echo $this->Html->script('AdminLTE./plugins/bootstrap/js/bootstrap.bundle.min.js');
	echo $this->Html->script('AdminLTE./js/adminlte.js');
?>

<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('scriptBottom'); ?>


<script type="text/javascript">
$(function () {
	var a = $('a[href="<?php echo $this->request->getPath(); ?>"]');
	
	if (!a.parent().hasClass('has-treeview') && !a.parent().parent().hasClass('pagination')) {
        a.parent().addClass('menu-open').parents('.has-treeview').addClass('menu-open');
    }
});
</script>

</body>
</html>
<?php } ?>
