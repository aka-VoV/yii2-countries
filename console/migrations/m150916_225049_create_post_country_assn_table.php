<?php

use yii\db\Migration;

class m150916_225049_create_post_country_assn_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%post_country_assn}}', [
            'post_id'       => $this->integer(11)->notNull(),
            'country_id'    => $this->integer(11)->notNull(),
        ]);
        //$this->addPrimaryKey('', '{{%post_country_assn}}', ['post_id', 'country_id']);
        $this->createIndex('FK_post_country', '{{%post_country_assn}}', ['post_id', 'country_id']);
    }

    public function safeDown()
    {
        echo "Removing tables.\n";
        $this->dropTable('{{%post_country_assn}}');
    }

}
