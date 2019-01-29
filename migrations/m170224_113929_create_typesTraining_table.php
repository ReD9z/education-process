<?php

use yii\db\Migration;

/**
 * Handles the creation of table `typesTraining`.
 */
class m170224_113929_create_typesTraining_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('typesTraining', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'color' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('typesTraining');
    }
}
