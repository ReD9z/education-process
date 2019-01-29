<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m170216_134444_create_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'image' => $this->string()->notNull(),
            'users_id' => $this->integer()->notNull(),
            'address' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-profile-users_id',
            'profile',
            'users_id'
        );

        $this->addForeignKey(
            'fk-profile-users_id',
            'profile',
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
        $this->dropTable('profile');
    }
}
