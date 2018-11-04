<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "google_tfa".
 *
 * @property int $id
 * @property string $secret
 * @property int $user_id
 */
class GoogleTfa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'google_tfa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['secret'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'secret' => 'Secret',
            'user_id' => 'User ID',
        ];
    }
}
