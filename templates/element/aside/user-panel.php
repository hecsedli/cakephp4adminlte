<?php
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$prefix = '';
if($this->request->getParam('prefix')) $prefix = DS . Inflector::camelize($this->request->getParam('prefix'));

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . $prefix . DS . 'Element' . DS . 'aside' . DS . 'user-panel.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
     <div class="image">
        <?php echo $this->Html->image('user2-160x160.jpg', array('class' => 'img-circle elevation-2', 'alt' => 'User Image')); ?>
    </div>
    <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
    </div>
</div>
<?php } ?>
