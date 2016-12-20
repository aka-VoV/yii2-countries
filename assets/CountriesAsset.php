<?php
/**
 * Created by PhpStorm.
 * User: Vladimir
 * Date: 9/18/2015
 * Time: 12:32 AM
 */

namespace akavov\countries\assets;

use yii\web\AssetBundle;
use Yii;

class CountriesAsset extends AssetBundle
{
    public $sourcePath = '';
    public $css = [
        'css/flag-icon.min.css',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    /**
     * @inheritdoc
     */
    public function init() {
        $this->sourcePath = "@bower/flag-icon-css";
        parent::init();
    }
}
