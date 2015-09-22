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
use yii\helpers\Json;
use yii\web\JsExpression;
use Yii;
use yii\web\Response;
use ict\posts\common\models\Country;

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
        $this->clientOptions['options'] = new JsExpression($this->getAllCountries());
        parent::registerClientScript();
    }

    /**
     * Return matched countries
     * @param  string $query
     * @return json result array
     */
    public function getAllCountries($query = null)
    {
        $list = Country::find()
            //->where(['like','name_en', $query])
            //->orWhere(['like','name_uk', $query])
            //->orWhere(['like','name_ru', $query])
            ->all();
        return Json::encode($list);
    }

}