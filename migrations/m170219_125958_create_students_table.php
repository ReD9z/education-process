<?php

use yii\db\Migration;

/**
 * Handles the creation of table `students`.
 */
class m170219_125958_create_students_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('students', [
            'id' => $this->primaryKey(),
            'groups_id' => $this->integer()->notNull(),
            'users_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-students-groups_id',
            'students',
            'groups_id'
        );

        $this->addForeignKey(
            'fk-students-groups_id',
            'students',
            'groups_id',
            'groups',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-students-users_id',
            'students',
            'users_id'
        );

        $this->addForeignKey(
            'fk-students-users_id',
            'students',
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
        $this->dropTable('students');
    }
}
