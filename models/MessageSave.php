<?php


namespace app\models;
use yii\db\ActiveRecord;

class MessageSave extends ActiveRecord
{
    //public $messagetext;
    //public $userto;
    //public $userfrom;

    public static function tableName()
    {
        return 'message';
    }

    public function rules()
    {
        return [
            [['messagetext', 'userto', 'userfrom'], 'required'],
        ];
    }
}