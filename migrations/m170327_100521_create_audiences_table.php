<?php

use yii\db\Migration;

/**
 * Handles the creation of table `audiences`.
 */
class m170327_100521_create_audiences_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('audiences', [
            'id' => $this->primaryKey(),
            'institute_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-audiences-institute_id',
            'audiences',
            'institute_id'
        );

        $this->addForeignKey(
            'fk-audiences-institute_id',
            'audiences',
            'institute_id',
            'institute',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('audiences');
    }
}
