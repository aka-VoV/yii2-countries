<?php

namespace akavov\countries\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;


class CountriesBehavior extends Behavior
{

    /**
     * @var string the countries relation name
     */
    public $countryRelation = 'countries';
    /**
     * @var string the tags model value attribute name
     */
    public $countryValueAttribute = 'alpha';
    /**
     * @var string[]
     */
    private $_countryValues;
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT    => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE   => 'beforeDelete',
        ];
    }

    public function getCountryValues(){

        /* @var ActiveRecord $tag */
        foreach ($this->owner->{$this->countryRelation} as $country) {
            $this->_countryValues[] = $country->getAttribute($this->countryValueAttribute);
        }

    }

    /**
     * @return void
     */
    public function afterSave()
    {
        if ($this->_countryValues === null) {
            return;
        }

        $countryRelation = $this->owner->getRelation($this->countryRelation);
        $pivot = $countryRelation->via->from[0];
        /* @var ActiveRecord $class */
        $class = $countryRelation->modelClass;
        $rows = [];

        foreach ($this->_countryValues as $value) {
            /* @var ActiveRecord $tag */
            $country = $class::findOne([$this->countryValueAttribute => $value]);

            if ($country === null) {
                $country = new $class();
                $country->setAttribute($this->countryValueAttribute, $value);
            }


            if ($country->save()) {
                $rows[] = [$this->owner->getPrimaryKey(), $country->getPrimaryKey()];
            }
        }

        if (!empty($rows)) {
            $this->owner->getDb()
                ->createCommand()
                ->batchInsert($pivot, [key($countryRelation->via->link), current($countryRelation->link)], $rows)
                ->execute();
        }
    }
}
