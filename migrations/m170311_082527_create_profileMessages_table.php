<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profileMessages`.
 */
class m170311_082527_create_profileMessages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('profileMessages', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'users_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'date' => $this->timestamp(),
        ]);
        
        $this->createIndex(
            'idx-profileMessages-users_id',
            'profileMessages',
            'users_id'
        );

        $this->addForeignKey(
            'fk-profileMessages-users_id',
            'profileMessages',
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
        $this->dropTable('profileMessages');
    }
}
