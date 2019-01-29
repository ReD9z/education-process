<?php

use yii\db\Migration;

/**
 * Handles the creation of table `study`.
 */
class m170223_091534_create_study_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('study', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('study');
    }
}
