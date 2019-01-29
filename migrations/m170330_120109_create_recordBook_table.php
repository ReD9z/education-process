<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recordBook`.
 */
class m170330_120109_create_recordBook_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('recordBook', [
            'id' => $this->primaryKey(),
            'timetable_id' => $this->integer()->notNull(),
            'students_id' => $this->integer()->notNull(),
            'evaluation_id' => $this->integer()->notNull(),
            'visit_id' => $this->integer()->notNull(),
            'date' => $this->date(),
        ]);

        $this->createIndex(
            'idx-recordBook-visit_id',
            'recordBook',
            'visit_id'
        );

        $this->addForeignKey(
            'fk-recordBook-visit_id',
            'recordBook',
            'visit_id',
            'visit',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-recordBook-evaluation_id',
            'recordBook',
            'evaluation_id'
        );

        $this->addForeignKey(
            'fk-recordBook-evaluation_id',
            'recordBook',
            'evaluation_id',
            'evaluation',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-recordBook-students_id',
            'recordBook',
            'students_id'
        );

        $this->addForeignKey(
            'fk-recordBook-students_id',
            'recordBook',
            'students_id',
            'students',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-recordBook-timetable_id',
            'recordBook',
            'timetable_id'
        );

        $this->addForeignKey(
            'fk-recordBook-timetable_id',
            'recordBook',
            'timetable_id',
            'timetable',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('recordBook');
    }
}
