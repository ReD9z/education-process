<?php

use yii\db\Migration;

/**
 * Handles the creation of table `direction`.
 */
class m170219_124024_create_direction_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('direction', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'small_name' => $this->string()->notNull(),
            'chair_id' => $this->integer()->notNull(),
            'study_id' => $this->integer()->notNull(),
            'qualification_id' => $this->integer()->notNull(),
            'period' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-direction-qualification_id',
            'direction',
            'qualification_id'
        );

        $this->addForeignKey(
            'fk-direction-qualification_id',
            'direction',
            'qualification_id',
            'qualification',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-direction-chair_id',
            'direction',
            'chair_id'
        );

        $this->addForeignKey(
            'fk-direction-chair_id',
            'direction',
            'chair_id',
            'chair',
            'id',
            'CASCADE'
        );

         $this->createIndex(
            'idx-direction-study_id',
            'direction',
            'study_id'
        );

        $this->addForeignKey(
            'fk-direction-study_id',
            'direction',
            'study_id',
            'study',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('direction');
    }
}
