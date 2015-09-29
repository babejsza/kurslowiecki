<?php

use yii\db\Schema;
use yii\db\Migration;

class m150928_075740_add_answer_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('answer', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'title' => $this->text()->notNull(),
            'author_id' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'active' => $this->boolean()->defaultValue(1)->notNull()
        ]);



        $this->addForeignKey('fk_question_author_id', 'question', 'author_id', 'user', 'id');

        $this->addForeignKey('fk_answer_question_id', 'answer', 'question_id', 'question', 'id');
        $this->addForeignKey('fk_answer_author_id', 'answer', 'author_id', 'user', 'id');

        passthru('php yii question-import');

        $this->addForeignKey('fk_question_correct_answer_id', 'question', 'correct_answer_id', 'answer', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_question_correct_answer_id', 'question');

        $this->truncateTable('answer');

        $this->dropForeignKey('fk_answer_author_id', 'answer');
        $this->dropForeignKey('fk_answer_question_id', 'answer');

        $this->dropForeignKey('fk_question_author_id', 'question');

        $this->dropTable('answer');
    }
}
