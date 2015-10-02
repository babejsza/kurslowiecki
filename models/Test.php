<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $created_at
 * @property string $ended_at
 *
 * @property User $user
 * @property TestUserQuestionAnswer[] $testUserQuestionAnswers
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'ended_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'ended_at' => Yii::t('app', 'Ended At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestUserQuestionAnswers()
    {
        return $this->hasMany(TestUserQuestionAnswer::className(), ['test_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestQuery(get_called_class());
    }
}
