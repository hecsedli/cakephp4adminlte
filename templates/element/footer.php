<?php
use Cake\Utility\Inflector;

$prefix = '';
if($this->request->getParam('prefix')) $prefix = DS . Inflector::camelize($this->request->getParam('prefix'));

$file = ROOT . DS . 'templates' . $prefix . DS . 'Element' . DS . 'footer.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
</footer>
<?php } ?>