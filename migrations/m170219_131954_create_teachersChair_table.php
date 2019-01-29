<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teachersChair`.
 */
class m170219_131954_create_teachersChair_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teachersChair', [
            'id' => $this->primaryKey(),
            'chair_id' => $this->integer()->Null(),
            'users_id' => $this->integer()->Null(),
        ]);
        
        $this->createIndex(
            'idx-teachersChair-chair_id',
            'teachersChair',
            'chair_id'
        );

        $this->addForeignKey(
            'fk-teachersChair-chair_id',
            'teachersChair',
            'chair_id',
            'chair',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-teachersChair-users_id',
            'teachersChair',
            'users_id'
        );

        $this->addForeignKey(
            'fk-teachersChair-users_id',
            'teachersChair',
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
        $this->dropTable('teachersChair');
    }
}
