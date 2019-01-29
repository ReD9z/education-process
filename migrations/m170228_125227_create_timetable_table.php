<?php

use yii\db\Migration;

/**
 * Handles the creation of table `timetable`.
 */
class m170228_125227_create_timetable_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('timetable', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer()->notNull(),
            'groups_id' => $this->integer()->notNull(),
            'plan_id' => $this->integer()->notNull(),
            'couple_id' => $this->integer()->notNull(),
            'training_choice_id' => $this->integer()->notNull(),
            'audiences_id' => $this->integer()->notNull(),
            'date' => $this->date(),
        ]);

        $this->createIndex(
            'idx-timetable-audiences_id',
            'timetable',
            'audiences_id'
        );

        $this->addForeignKey(
            'fk-timetable-audiences_id',
            'timetable',
            'audiences_id',
            'audiences',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-timetable-training_choice_id',
            'timetable',
            'training_choice_id'
        );

        $this->addForeignKey(
            'fk-timetable-training_choice_id',
            'timetable',
            'training_choice_id',
            'trainingChoice',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-timetable-couple_id',
            'timetable',
            'couple_id'
        );

        $this->addForeignKey(
            'fk-timetable-couple_id',
            'timetable',
            'couple_id',
            'couple',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-timetable-plan_id',
            'timetable',
            'plan_id'
        );

        $this->addForeignKey(
            'fk-timetable-plan_id',
            'timetable',
            'plan_id',
            'plan',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-timetable-groups_id',
            'timetable',
            'groups_id'
        );

        $this->addForeignKey(
            'fk-timetable-groups_id',
            'timetable',
            'groups_id',
            'groups',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-timetable-users_id',
            'timetable',
            'users_id'
        );

        $this->addForeignKey(
            'fk-timetable-users_id',
            'timetable',
            'users_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('timetable');
    }
}
