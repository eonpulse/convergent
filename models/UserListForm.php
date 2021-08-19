<?php


namespace app\models;
use yii\db\ActiveRecord;

class UserListForm extends ActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }



}