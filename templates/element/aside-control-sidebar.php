<?php
use Cake\Utility\Inflector;

$prefix = '';
if($this->request->getParam('prefix')) $prefix = DS . Inflector::camelize($this->request->getParam('prefix'));

$file = ROOT . DS . 'templates' . $prefix . DS . 'Element' . DS . 'aside-control-sidebar.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<aside class="control-sidebar control-sidebar-dark">
	
</aside>
<?php
}
?>
