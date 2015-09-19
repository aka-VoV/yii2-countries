<?php
/**
 * Created by PhpStorm.
 * User: Vladimir
 * Date: 9/18/2015
 * Time: 12:38 AM
 */

namespace akavov\countries\widgets;
use dosamigos\selectize\SelectizeTextInput;
use akavov\countries\assets\CountriesAsset;
use yii\web\JsExpression;

class CountriesSelectizeTextInput extends SelectizeTextInput
{


    /**
     * @var array
     */
    public $customRender;
    /**
     * @var array
     */
    private $patterns = array('/{/', '/}/');
    /**
     * @var array
     */
    private $replacement = array('\'+', '+\'');
    /**
     * @inheritdoc
     */
    public function run(){
        $view = $this->getView();
        CountriesAsset::register($view);
        parent::run();
    }

    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {

        if ($this->customRender !== null && !empty($this->customRender)) {

            foreach($this->customRender as $template => $templateValue){
                $templateValue = preg_replace($this->patterns, $this->replacement, $templateValue);
                $this->clientOptions['render'][$template] = new JsExpression("function(item, escape_html){return '$templateValue';}");
            }

        }

       parent::registerClientScript();
    }

}