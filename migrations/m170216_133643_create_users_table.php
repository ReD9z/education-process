<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170216_133643_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull(),
            'password' =>$this->string()->notNull(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string()->Null(),
            'role_id' => $this->integer()->notNull(),
            'date' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-users-role_id',
            'users',
            'role_id'
        );

        $this->addForeignKey(
            'fk-users-role_id',
            'users',
            'role_id',
            'role',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
