<?php

namespace akavov\countries;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;


class CountriesBehavior extends Behavior
{


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }


}
