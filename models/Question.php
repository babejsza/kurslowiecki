<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property string $title
 * @property integer $occured_number
 * @property integer $correct_answer_id
 * @property integer $author_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $active
 *
 * @property Answer[] $answers
 * @property User $author
 * @property Answer $correctAnswer
 * @property TestUserQuestionAnswer[] $testUserQuestionAnswers
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'correct_answer_id'], 'required'],
            [['title'], 'string'],
            [['occured_number', 'correct_answer_id', 'author_id', 'active'], 'integer'],
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
            'title' => Yii::t('app', 'Title'),
            'occured_number' => Yii::t('app', 'Occured Number'),
            'correct_answer_id' => Yii::t('app', 'Correct Answer ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorrectAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'correct_answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestUserQuestionAnswers()
    {
        return $this->hasMany(TestUserQuestionAnswer::className(), ['question_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return QuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionQuery(get_called_class());
    }
}
