Widget Countries in the world with flags
===========================================
ISO 3166-1 numeric code, ISO 3166-1 alpha-2 code, ITU-T calling code and name (English, Russian and Ukrainian) for all the countries in the world with their flags

**Thanks to:**

https://github.com/victordzmr/Countries
https://github.com/lipis/flag-icon-css
https://github.com/2amigos/yii2-selectize-widget


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist akavov/yii2-countries "*"
```

or add

```
"akavov/yii2-countries": "*"
```


Migration
======
you can use migrations that already exist in console/migartions

```
$ yii migrate --migrationPath='@akavov/countries/console/migrations'
```
or
```
$ yii migrate --migrationPath=@vendor/akavov/yii2-countries/console/migartions
```
it will create a databases:
	1. country - with some data (249 countries in english[name_en]) in it
	2. post_country_assn - depends from table post and table country

You can use this migartions like a example and create needed tables yourself


Configuring
======
Configure model as follows

```
<?php

namespace ict\posts\common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use creocoder\taggable\TaggableBehavior;
use akavov\countries\components\CountriesBehavior;

/**
 * This is the model class for table "{{%post}}".
 * ...
 * @property string $countryValues
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    public function behaviors()
    {
        return [
			...
            [
                'class' => CountriesBehavior::className(),
            ],
            ...
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        ...
            ['countryValues', 'safe'],
            ...
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['id' => 'country_id'])
            ->viaTable('{{%post_country_assn}}', ['post_id' => 'id']);
    }

}

```

Usage
-----

```
    <?= $form->field($model, 'countryValues')
    ->widget(akavov\countries\widgets\CountriesSelectizeTextInput::className(), [
        'customRender' => [
            'item'  => '<div> <span class="label flag flag-icon-background flag-icon-{item.alpha}">&nbsp;</span>&nbsp;<span class="name">{escape(item.name_en)}</span></div>',
            'option'  => '<div> <span class="label flag flag-icon-background flag-icon-{item.alpha}">&nbsp;</span>&nbsp;<span class="name">{escape(item.name_en)}</span></div>',
        ],
        'clientOptions' => [
            'valueField' => 'name_en',
            'labelField' => 'name_en',
            'searchField' => ['name_en', 'name_uk', 'name_ru'],
            'plugins' => ['remove_button'],
            'closeAfterSelect' => true,
            'maxItems' => 10,
            'delimiter' => ',',
            'persist' => false,
            'preload' => true,
            'items' => $model->countryValues,
            'create' => false,
        ],
    ]); ?>
```
