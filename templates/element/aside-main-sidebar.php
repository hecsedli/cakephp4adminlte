<?php
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$prefix = '';
if($this->request->getParam('prefix')) $prefix = DS . Inflector::camelize($this->request->getParam('prefix'));

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . $prefix . DS . 'Element' . DS . 'aside-main-sidebar.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
    <a href="<?php echo $this->Url->build(['controller' => 'Pages', 'action' => 'dashboard']); ?>" class="brand-link">
      <?php echo $this->Html->image('AdminLTE.AdminLTELogo.png', ['alt' => 'AdminLTE Logo', 'class' => 'brand-image img-circle elevation-3', 'style' => 'opacity: .8']); ?>
	  <span class="brand-text font-weight-light"><?php echo Configure::read('Theme.logo.large'); ?></span>
    </a>
	
	<div class="sidebar">
        <!-- Sidebar user panel -->
        <?php echo $this->element('AdminLTE.aside/user-panel'); ?>

        <!-- search form -->
        <?php echo $this->element('AdminLTE.aside/form'); ?>
        <!-- /.search form -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php echo $this->element('AdminLTE.aside/sidebar-menu'); ?>

    </div>
    <!-- /.sidebar -->
</aside>
<?php } ?>
