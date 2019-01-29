<?php

use yii\db\Migration;

/**
 * Handles the creation of table `evaluation`.
 */
class m170301_151505_create_evaluation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('evaluation', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('evaluation');
    }
}
