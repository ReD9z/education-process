<?php

use yii\db\Migration;

/**
 * Handles the creation of table `couple`.
 */
class m170228_125858_create_couple_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('couple', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'start' => $this->time();
            'end' => $this->time();
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('couple');
    }
}
