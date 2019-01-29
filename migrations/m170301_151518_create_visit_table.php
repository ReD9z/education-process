<?php

use yii\db\Migration;

/**
 * Handles the creation of table `visit`.
 */
class m170301_151518_create_visit_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('visit', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('visit');
    }
}
