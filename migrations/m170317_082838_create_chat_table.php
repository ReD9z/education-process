<?php

use yii\db\Migration;

/**
 * Handles the creation of table `chat`.
 */
class m170317_082838_create_chat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'users_id' => $this->integer()->notNull(),
            'users_send' => $this->integer()->notNull(),
            'date' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-chat-users_send',
            'chat',
            'users_send'
        );

        $this->addForeignKey(
            'fk-chat-users_send',
            'chat',
            'users_send',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-chat-users_id',
            'chat',
            'users_id'
        );

        $this->addForeignKey(
            'fk-chat-users_id',
            'chat',
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
        $this->dropTable('chat');
    }
}
