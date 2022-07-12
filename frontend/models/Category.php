<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $cat_name
 * @property string $created_date
 * @property int $created_by
 * @property string $record_status
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_name', 'created_by'], 'required'],
            [['created_date'], 'safe'],
            [['created_by'], 'integer'],
            [['cat_name'], 'string', 'max' => 255],
            [['record_status'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'record_status' => 'Record Status',
        ];
    }
}
