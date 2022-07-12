<?php
namespace app\models;
use Yii;

class Report extends  \yii\base\Model
{
    public $start_date,$end_date;
    public function rules()
    {
        return [
            [['start_date','end_date'], 'string', 'max' => 255],
        ];
    }

   
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_name' => 'Item Name',
            'no_of_item' => 'No Of Item',
            'price' => 'Price',
            'date' => 'Date',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'record_status' => 'Record Status',
        ];
    }
}
