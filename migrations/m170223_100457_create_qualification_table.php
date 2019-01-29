<?php

use yii\db\Migration;

/**
 * Handles the creation of table `qualification`.
 */
class m170223_100457_create_qualification_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('qualification', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('qualification');
    }
}
