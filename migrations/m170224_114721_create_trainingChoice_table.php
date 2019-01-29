<?php

use yii\db\Migration;

/**
 * Handles the creation of table `trainingChoice`.
 */
class m170224_114721_create_trainingChoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('trainingChoice', [
            'id' => $this->primaryKey(),
            'types_training_id' => $this->integer()->notNull(),
            'plan_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-trainingChoice-plan_id',
            'trainingChoice',
            'plan_id'
        );

        $this->addForeignKey(
            'fk-trainingChoice-plan_id',
            'trainingChoice',
            'plan_id',
            'plan',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-trainingChoice-types_training_id',
            'trainingChoice',
            'types_training_id'
        );

        $this->addForeignKey(
            'fk-trainingChoice-types_training_id',
            'trainingChoice',
            'types_training_id',
            'typesTraining',
            'id',
            'CASCADE'
        );
    }  

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('trainingChoice');
    }
}
