<?php

use yii\db\Schema;
use yii\db\Migration;

class m150928_075605_add_question_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('question', [
            'id' => $this->primaryKey(),
            'title' => $this->text()->notNull(),
            'occured_number' => $this->integer()->defaultValue(0),
            'correct_answer_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'active' => $this->boolean()->defaultValue(1)->notNull()
        ]);


    }

    public function safeDown()
    {
        $this->dropTable('question');
    }
}
