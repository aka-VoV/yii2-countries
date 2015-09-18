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

class CountriesSelectizeTextInput extends SelectizeTextInput
{
    public function run(){
        $view = $this->getView();
        CountriesAsset::register($view);
        parent::run();
    }
}