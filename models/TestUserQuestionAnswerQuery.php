<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TestUserQuestionAnswer]].
 *
 * @see TestUserQuestionAnswer
 */
class TestUserQuestionAnswerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TestUserQuestionAnswer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TestUserQuestionAnswer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}