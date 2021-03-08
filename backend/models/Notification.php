<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $auto_id
 * @property integer $user_id
 * @property integer $notification_id
 * @property string $create_date
 * @property string $update_date
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'notification_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'user_id' => 'User ID',
            'notification_id' => 'Notification ID',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
        ];
    }
}
