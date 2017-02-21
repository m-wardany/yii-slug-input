<?php

namespace wardany\slugify;


use yii\base\InvalidConfigException;
use yii\bootstrap\InputWidget;
use yii\helpers\Html;

/**
 * Description of Slugify
 * this widget is useing slugify.js by mathewbyrne https://gist.github.com/mathewbyrne/1280286
 * @author muhammad wardany <muhammad.wardany@gmail.com>
 */

class Slugify extends InputWidget{
    /**
     * @var string the model attribute that this widget use to generate slug.
     */
    public $source_attribute ;
    
    /**
     * @var string slug separator default '-'.
     */
    public $separator = '-';
    
    /**
     * @var int attribute Html id default is null , Id is used if $source_attribute is null.
     */
    public $id = null;
    
    /**
     * @var boolean either to disable slug input or not default to false
     */
    public $disable = false;
    
    public function init() {
        parent::init();
        if ($this->source_attribute === null && $this->id === null) {
            throw new InvalidConfigException("Either 'source_attribute', or 'id' properties must be specified.");
        }
    }
    
    public function run() {
        $id = $this->id === null? Html::getInputId($this->model, $this->source_attribute): $this->id;
        $target_id = $this->options['id'];
        
        echo $this->renderWidget() . "\n";
        
        echo $this->view->registerJs("
            jQuery(document).on('keyup', '#{$id}', function(){
                text = $(this).val().toString().toLowerCase()
                        .replace(/\s+/g, '{$this->separator}')                                              // Replace spaces with separator
                        .replace(/\-+/g, '{$this->separator}')                                              // Replace dashes with separator
                        .replace(/[^\w\-]+/g, '')                                                           // Remove all non-word chars
                        .replace(/\{$this->separator}\{$this->separator}+/g, '{$this->separator}')          // Replace multiple separator with single separator
                        .replace(/^{$this->separator}+/, '')                                                // Trim separator from start of text
                        .replace(/{$this->separator}+$/, '');                                               // Trim separator from end of text
                $('#{$target_id}').val(text);
                
            });", \yii\web\View::POS_END);
    }
    
    protected function renderWidget()
    {
        $contents = [];

        // get formatted date value
        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }
        
        $options = $this->options;
        $options['value'] = $value;
        if(!key_exists('class', $options))
            $options['class']= 'form-control';
        
        if($this->disable)
            $options[' disabled']= true;

        // render a text input
        if ($this->hasModel()) {
            $contents[] = Html::activeTextInput($this->model, $this->attribute, $options);
        } else {
            $contents[] = Html::textInput($this->name, $value, $options);
        }
       

        return implode("\n", $contents);
    }
}
