<?php

use yii\db\Migration;

/**
 * Handles the creation of table `discipline`.
 */
class m170219_130055_create_discipline_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('discipline', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('discipline');
    }
}
