<?php

use yii\db\Migration;

/**
 * Handles the creation of table `chair`.
 */
class m170219_123951_create_chair_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('chair', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'small_name' => $this->string()->notNull(),
            'institute_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-chair-institute_id',
            'chair',
            'institute_id'
        );

        $this->addForeignKey(
            'fk-chair-institute_id',
            'chair',
            'institute_id',
            'institute',
            'id',
            'CASCADE'
        );
    }

   
    public function down()
    {
        $this->dropTable('chair');
    }
}
