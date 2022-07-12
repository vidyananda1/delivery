<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
           // 'type',
            [
                    'header' => 'Action',
                    'headerOptions' => ['width' => '80'],
                    'content' => function($model, $key, $index, $column) {

                return Html::a('<span class="glyphicon glyphicon-wrench", title="RESET PASSWORD" ></span>',  ['reset_password', 'id' => $model->id]);
                },
                ],
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view},{update}'],
        ],
    ]); ?>
</div>
