<?php

use yii\db\Migration;

/**
 * Handles the creation of table `semester`.
 */
class m170223_153627_create_semester_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('semester', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('semester');
    }
}
