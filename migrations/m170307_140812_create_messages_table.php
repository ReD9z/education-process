<?php

use yii\db\Migration;

/**
 * Handles the creation of table `messages`.
 */
class m170307_140812_create_messages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('messages', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'users_id' => $this->integer()->notNull(),
            'groups_id' => $this->integer()->notNull(),
            'date' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-messages-groups_id',
            'messages',
            'groups_id'
        );

        $this->addForeignKey(
            'fk-messages-groups_id',
            'messages',
            'groups_id',
            'groups',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-messages-users_id',
            'messages',
            'users_id'
        );

        $this->addForeignKey(
            'fk-messages-users_id',
            'messages',
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
        $this->dropTable('messages');
    }
}
