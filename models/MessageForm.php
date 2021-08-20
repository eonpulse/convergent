<?php


namespace app\models;

use yii\base\Model;

class MessageForm extends Model
{
    public $messagetext;
    public $userto;
    public $userfrom;

    public function rules()
    {
        return [
            [['messagetext', 'userto'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'messagetext' => 'Текст сообщения',
            'userto' => '',
        ];
    }
}