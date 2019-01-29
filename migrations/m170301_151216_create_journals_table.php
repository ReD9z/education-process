<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journals`.
 */
class m170301_151216_create_journals_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('journals', [
            'id' => $this->primaryKey(),
            'students_id' => $this->integer()->notNull(),
            'timetable_id' => $this->integer()->notNull(),
            'evaluation_id' => $this->integer()->notNull(),
            'visit_id' => $this->integer()->notNull(),
            'date' => $this->date(),
        ]);

        $this->createIndex(
            'idx-journals-visit_id',
            'journals',
            'visit_id'
        );

        $this->addForeignKey(
            'fk-journals-visit_id',
            'journals',
            'visit_id',
            'visit',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-journals-evaluation_id',
            'journals',
            'evaluation_id'
        );

        $this->addForeignKey(
            'fk-journals-evaluation_id',
            'journals',
            'evaluation_id',
            'evaluation',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-journals-timetable_id',
            'journals',
            'timetable_id'
        );

        $this->addForeignKey(
            'fk-journals-timetable_id',
            'journals',
            'timetable_id',
            'timetable',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-journals-students_id',
            'journals',
            'students_id'
        );

        $this->addForeignKey(
            'fk-journals-students_id',
            'journals',
            'students_id',
            'students',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('journals');
    }
}
