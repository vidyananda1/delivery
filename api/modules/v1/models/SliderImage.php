<?php

namespace api\modules\v1\models;

use Yii\db\ActiveRecord;
use Yii;
use yii\web\UploadedFile;
use Exception;

/**
 * This is the model class for table "slider_image".
 *
 * @property int $id
 * @property string $images
 * @property string $image_title
 * @property int $created_by
 * @property string $created_date
 * @property int|null $updated_by
 * @property string|null $updated_date
 * @property string $record_status
 */
class SliderImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider_image';
    }

    /**
     * {@inheritdoc}
     */

    public $imagefile;
    public function rules()
    {
        return [
            [['image_title', 'created_by','images'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['images,image_title'], 'string', 'max' => 255],
            [['record_status'], 'string', 'max' => 1],
            [['imagefile'],'file','maxSize' => 1024*400,'extensions'=>'png,jpg,jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'images' => 'Images',
            'image_title' => 'Image Title',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'record_status' => 'Record Status',
        ];
    }

    public function getImageurl() {
        //$url = $this->get_space_file($this->images);
        $url = Yii::$app->request->BaseUrl.'/images/'.$this->images;
        return $url;
    }
}
