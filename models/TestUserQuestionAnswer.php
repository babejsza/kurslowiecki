<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_user_question_answer".
 *
 * @property integer $id
 * @property integer $test_id
 * @property integer $user_id
 * @property integer $question_id
 * @property integer $answer_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Answer $answer
 * @property Question $question
 * @property Test $test
 * @property User $user
 */
class TestUserQuestionAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_user_question_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_id', 'user_id', 'question_id', 'answer_id'], 'required'],
            [['test_id', 'user_id', 'question_id', 'answer_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'test_id' => Yii::t('app', 'Test ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'question_id' => Yii::t('app', 'Question ID'),
            'answer_id' => Yii::t('app', 'Answer ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return TestUserQuestionAnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestUserQuestionAnswerQuery(get_called_class());
    }
}
