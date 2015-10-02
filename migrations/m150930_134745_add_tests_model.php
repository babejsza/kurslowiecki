<?php

use yii\db\Schema;
use yii\db\Migration;

class m150930_134745_add_tests_model extends Migration
{
    public function safeUp()
    {
        $this->createTable('test', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'ended_at' => $this->dateTime()
        ]);

        $this->createTable('test_user_question_answer', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
            'answer_id' => $this->integer()->notNull(),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->addForeignKey('fk_test_user_id', 'test', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_test_user_question_answer_test_id', 'test_user_question_answer', 'test_id', 'test', 'id');
        $this->addForeignKey('fk_test_user_question_answer_user_id', 'test_user_question_answer', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_test_user_question_answer_question_id', 'test_user_question_answer', 'question_id', 'question', 'id');
        $this->addForeignKey('fk_test_user_question_answer_answer_id', 'test_user_question_answer', 'answer_id', 'answer', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_test_user_question_answer_answer_id', 'test_user_question_answer');
        $this->dropForeignKey('fk_test_user_question_answer_question_id', 'test_user_question_answer');
        $this->dropForeignKey('fk_test_user_question_answer_user_id', 'test_user_question_answer');
        $this->dropForeignKey('fk_test_user_question_answer_test_id', 'test_user_question_answer');
        $this->dropForeignKey('fk_test_user_id', 'test');

        $this->dropTable('test_user_question_answer');

        $this->dropTable('test');
    }
}
