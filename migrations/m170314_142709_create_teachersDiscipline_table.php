<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teachersDiscipline`.
 */
class m170314_142709_create_teachersDiscipline_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teachersDiscipline', [
            'id' => $this->primaryKey(),
            'teachers_chair' => $this->integer()->notNull(),
            'discipline_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-teachersDiscipline-discipline_id',
            'teachersDiscipline',
            'discipline_id'
        );

        $this->addForeignKey(
            'fk-teachersDiscipline-discipline_id',
            'teachersDiscipline',
            'discipline_id',
            'discipline',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-teachersDiscipline-teachers_chair',
            'teachersDiscipline',
            'teachers_chair'
        );

        $this->addForeignKey(
            'fk-teachersDiscipline-teachers_chair',
            'teachersDiscipline',
            'teachers_chair',
            'teachersChair',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('teachersDiscipline');
    }
}
