<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m170401_164927_create_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'students_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'date' => $this->date(),    
        ]);

        $this->createIndex(
            'idx-payment-course_id',
            'payment',
            'course_id'
        );

        $this->addForeignKey(
            'fk-payment-course_id',
            'payment',
            'course_id',
            'course',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-payment-students_id',
            'payment',
            'students_id'
        );

        $this->addForeignKey(
            'fk-payment-students_id',
            'payment',
            'students_id',
            'students',
            'id',
            'CASCADE'
        );
    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payment');
    }
}
