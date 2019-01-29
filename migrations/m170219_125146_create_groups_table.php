<?php

use yii\db\Migration;

/**
 * Handles the creation of table `groups`.
 */
class m170219_125146_create_groups_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('groups', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'direction_id' => $this->integer()->notNull(),
        ]);
        
        $this->createIndex(
            'idx-groups-direction_id',
            'groups',
            'direction_id'
        );

        $this->addForeignKey(
            'fk-groups-direction_id',
            'groups',
            'direction_id',
            'direction',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('groups');
    }
}
