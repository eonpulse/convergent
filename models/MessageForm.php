<?php


namespace app\models;
use yii\db\ActiveRecord;

class MessageForm extends ActiveRecord
{
    public static function tableName()
    {
        return 'message';
    }
}