<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cabinet}}`.
 */
class m230111_062649_create_cabinet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->createTable('{{%cabinet}}', [
//            'id' => $this->primaryKey(),
//            'cabinet' => 'int null',
//            'corps_id' => 'int null',
//        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cabinet}}');
    }
}
