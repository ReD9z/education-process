<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plan`.
 */
class m170223_150353_create_plan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('plan', [
            'id' => $this->primaryKey(),
            'discipline_id' => $this->integer()->notNull(),
            'direction_id' => $this->integer()->notNull(),
            'time' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'semester_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-plan-semester_id',
            'plan',
            'semester_id'
        );

        $this->addForeignKey(
            'fk-plan-semester_id',
            'plan',
            'semester_id',
            'semester',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-plan-course_id',
            'plan',
            'course_id'
        );

        $this->addForeignKey(
            'fk-plan-course_id',
            'plan',
            'course_id',
            'course',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-plan-direction_id',
            'plan',
            'direction_id'
        );

        $this->addForeignKey(
            'fk-plan-direction_id',
            'plan',
            'direction_id',
            'direction',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-plan-discipline_id',
            'plan',
            'discipline_id'
        );

        $this->addForeignKey(
            'fk-plan-discipline_id',
            'plan',
            'discipline_id',
            'discipline',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('plan');
    }
}
