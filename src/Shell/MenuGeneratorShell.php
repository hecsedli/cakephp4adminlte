<?php

namespace AdminLTE\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Core\App;

/**
 * Menu generation utility for AdminLTE sidebar menu from database table names.
 *
 * Usage: bin/cake menu_generator
 *
 */

class MenuGeneratorShell extends Shell {
	
	public $connection = 'default';
	
    public function main() {
	    $connections = ConnectionManager::configured();
	    
        if (empty($connections)) {
            $this->out('Your database configuration was not found.');
            $this->out('Add your database connection information to config/app.php.');

            return false;
        }
        
        $db = ConnectionManager::get($this->connection);
        
        $prefix = '';
        
        $this->out(sprintf('<warning>Would you like to create a menu for prefix routing?</warning>'));
        $selection = $this->in('Enter prefix (eg: Admin) or n?', [], 'n');
        
        if(strtolower($selection) != 'n'){
	        $prefix = Inflector::camelize($selection);
	        $file = ROOT . DS . 'templates' . DS . $prefix . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp';
	    }else{
		    $file = ROOT . DS . 'templates' . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp'; 
	    }

		// Create a schema collection.
		$collection = $db->getSchemaCollection();

		// Get the table names
		$tables = $collection->listTables();
		
		$menuHtml = '<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu" data-accordion="false">
		<li class="nav-header"><?php echo __(\'MAIN NAVIGATION\');?></li>
		<li class="nav-item">
    		<a href="<?php echo $this->Url->build([\'controller\' => \'Pages\', \'action\' => \'dashboard\']); ?>" class="nav-link">
        		<i class="nav-icon fas fa-tachometer-alt"></i><p><?php echo __(\'Dashboard\');?></p>
			</a>
		</li>';
	
		if ($prefix) $prefix .= '/';
     
		foreach($tables as $table){
			if (in_array($table, ['acos', 'aros', 'aros_acos'])) continue;
			$controller = Inflector::camelize($table);
			$controllerClass = App::className($prefix . $controller, 'Controller', 'Controller');
			
			if (!class_exists($controllerClass))  continue;
			$menuHtml .= '
		<li class="nav-item">
    		<a href="<?php echo $this->Url->build([\'controller\' => \'' . Inflector::camelize($table) . '\', \'action\' => \'index\']); ?>" class="nav-link">
        		<i class="fas fa-table"></i><p><?php echo __(\''. Inflector::camelize($table) . '\');?></p>
			</a>
		</li>';
			
		}
        
        $menuHtml .= '
	</ul>
</nav>';
        	
        
		
        $this->createFile($file, $menuHtml);
    }
}