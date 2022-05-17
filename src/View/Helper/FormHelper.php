<?php

namespace AdminLTE\View\Helper;

use Cake\View\Helper\FormHelper as CakeFormHelper;
use Cake\Utility\Hash;
use Cake\View\View;
use Cake\Utility\Inflector;




class FormHelper extends CakeFormHelper {
	
	

    private $templates = [
        'button' => '{{before}}<button{{attrs}}>{{text}}</button>{{after}}',
         //Checkbox
        'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
        'checkboxFormGroup' => '{{input}}{{label}}',
        'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
        'checkboxContainer' => '<div class="form-group form-check {{required}}">{{content}}</div>',
        'checkboxContainerError' => '<div class="form-group form-check {{required}} error">{{content}}{{error}}</div>',
        
        'dateWidget' => '<div class="form-group">{{label}} {{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}</div>',
        'error' => '<div class="error-message">{{content}}</div>',
        'errorList' => '<ul>{{content}}</ul>',
        'errorItem' => '<li>{{text}}</li>',
        'file' => '<input type="file" name="{{name}}"{{attrs}}>',
        'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        'formStart' => '<form{{attrs}}>',
        'formEnd' => '</form>',
        'formGroup' => '{{label}}{{input}}',
        'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
        'inputSubmit' => '<input type="{{type}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group input {{type}}{{required}}">{{content}}</div>',
        'inputContainerError' => '<div class="form-group input {{type}}{{required}} error">{{content}}{{error}}</div>',
        'label' => '<label{{attrs}}>{{text}}</label>',
        'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
        'legend' => '<legend>{{text}}</legend>',
        'multicheckboxTitle' => '<legend>{{text}}</legend>',
        'multicheckboxWrapper' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
        'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
        'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
        'selectMultiple' => '<select name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
        'radioWrapper' => '<div class="radio">{{label}}</div>',
        'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
        'submitContainer' => '<div class="box-footer {{required}}">{{content}}</div>',
        
        
        
        //Datepicker
		'datePickerContainer' => '<div class="form-group">{{customLabel}}<div class="input-group date {{customClass}}" id="{{groupId}}" data-target-input="nearest">{{content}}</div></div>',
        'datePickerContainerError' => '<div class="form-group">{{customLabel}}<div class="input-group date" id="{{groupId}}" data-target-input="nearest">{{content}}{{error}}</div></div>',
        'datePickerFormGroup' => '<div class="input-group-prepend" data-target="#{{groupId}}" data-toggle="datetimepicker"><div class="input-group-text"><i class="far fa-calendar-alt"></i></div></div>{{input}}',
        'datePickerInputGroup' => '<div class="input-group-prepend" data-target="#{{groupId}}" data-toggle="datetimepicker"><div class="input-group-text"><i class="far fa-calendar-alt"></i></div></div>{{input}}{{inputGroupAppend}}',
        
        //File
        'fileFormGroup' => '{{label}}<div class="input-group"><div class="custom-file">{{input}}{{customLabel}}</div></div>',
        'fileInputGroup' => '{{label}}<div class="input-group">{{inputGroupPrepend}}<div class="custom-file">{{input}}{{customLabel}}</div>{{inputGroupAppend}}</div>',
        
        //inputGroup
        'inputGroup' => '{{label}}<div{{inputGroupAttrs}}>{{inputGroupPrepend}}{{input}}{{inputGroupAppend}}</div>',
        'inputGroupPrepend' => '<div class="input-group-prepend">{{prepend}}</div>',
        'inputGroupAppend' => '<div class="input-group-append">{{append}}</div>',
        
    ];

    public function __construct(View $View, array $config = [])
    {
        $this->_defaultConfig['templates'] = array_merge($this->_defaultConfig['templates'], $this->templates);
        parent::__construct($View, $config);
    }

    public function create($context = null, array $options = [])
    {
        $options += ['role' => 'form'];
        return parent::create($context, $options);
    }

    public function button($title, array $options = [])
    {
        $options += ['escape' => false, 'secure' => false, 'class' => 'btn btn-success'];
        $options['text'] = $title;
        return $this->widget('button', $options);
    }

    public function submit($caption = null, array $options = [])
    {
        $options += ['class' => 'btn btn-success'];
        return parent::submit($caption, $options);
    }
    
    public function datePicker($fieldName, array $options = []) {
    	$options = $this->_initInputField($fieldName, $options);
    	$options['type'] = 'text';
		return $this->widget('text', $options);
    }
    
    public function control($fieldName, array $options = [])
    {

        $_options = [];

        if (!isset($options['type'])) {
            $options['type'] = $this->_inputType($fieldName, $options);
        }
        
        

        switch($options['type']) {
	        case 'radio':
            case 'datetime':
            case 'date':
            case 'time':
                break;
            case 'checkbox':
            	$_options['class'] = 'form-check-input';
            	$_options['nestedInput'] = false;
            	$_options['label']['class'] = 'form-check-label';
            	break;
            case 'file':
            	$_options['class'] = 'custom-file-input';
            	if(!isset($options['placeholder'])) $options['placeholder'] = 'Choose file';
            	$_options['templateVars']['customLabel'] = $this->_getLabel($fieldName, ['type' => 'file', 'label' => ['class' => 'custom-file-label overflow-hidden', 'text' => $options['placeholder']]]);
            	unset($options['placeholder']);
            	break;
            case 'datePicker':
            case 'dateTimePicker':
             	$_options['templateVars']['customClass'] = $options['type'];
             	$groupId = $this->_domId($fieldName) . 'Group';
            	$_options['templateVars']['groupId'] = $groupId;
            	$_options['templateVars']['customLabel'] = $this->_getLabel($fieldName, $options);
            	$_options['class'] = 'form-control datetimepicker-input';
            	$_options['data-target'] = '#' . $groupId;
            	$_options['data-inputmask-alias'] = 'datetime'; 
            	$_options['inputmode'] = 'numeric';
            	$_options['data-mask'] = '';
            	if($options['type'] == 'datePicker') $_options['data-inputmask-inputformat'] = 'yyyy-mm-dd';
            	if($options['type'] == 'dateTimePicker') $_options['data-inputmask-inputformat'] = 'yyyy-mm-dd HH:MM';
            	$options['type'] = 'datePicker';
            	break;    
            default:
                $_options['class'] = 'form-control';
                break;

        }

        //$options += $_options;
        
        $options = array_replace_recursive($_options, $options);
        
        if(isset($options['prepend']) || isset($options['append'])){
	        
	        if(isset($options['prepend'])){
		        $options['templateVars']['inputGroupPrepend'] = $this->formatTemplate('inputGroupPrepend', $options);
		        unset($options['prepend']);
		    }
		    
		    if(isset($options['append'])){
		        $options['templateVars']['inputGroupAppend'] = $this->formatTemplate('inputGroupAppend', $options);
		        unset($options['append']);
		    }
		    
		    if(!isset($options['inputGroupAttrs'])){
			    $options['inputGroupAttrs'] = ['class' => 'input-group'];
			}
			
			
			$options['templateVars']['inputGroupAttrs'] = $this->templater()->formatAttributes($options['inputGroupAttrs']);
	        unset($options['inputGroupAttrs']);
	        
	        $groupTemplate = $options['type'] . 'FormGroup';
	        if (!$this->getTemplates($groupTemplate)) $groupTemplate = 'formGroup';
        	
        	$inputGroupTemplate = $options['type'] . 'InputGroup';
        	if (!$this->getTemplates($inputGroupTemplate)) $inputGroupTemplate = 'inputGroup';
        	
        	$options['templates'][$groupTemplate] =  $this->getTemplates($inputGroupTemplate);
        }
	   
        
        return parent::control($fieldName, $options);
    }
}
