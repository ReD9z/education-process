<?php

use yii\db\Migration;

/**
 * Handles the creation of table `institute`.
 */
class m170219_123902_create_institute_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('institute', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'small_name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('institute');
    }
}
