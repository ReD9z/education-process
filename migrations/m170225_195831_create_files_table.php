<?php

use yii\db\Migration;

/**
 * Handles the creation of table `files`.
 */
class m170225_195831_create_files_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('files', [
            'id' => $this->primaryKey(),
            'training_choice_id' => $this->integer()->notNull(),
            'plan_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-files-plan_id',
            'files',
            'plan_id'
        );

        $this->addForeignKey(
            'fk-files-plan_id',
            'files',
            'plan_id',
            'plan',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-files-training_choice_id',
            'files',
            'training_choice_id'
        );

        $this->addForeignKey(
            'fk-files-training_choice_id',
            'files',
            'training_choice_id',
            'trainingChoice',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('files');
    }
}
