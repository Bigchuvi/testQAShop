<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use frontend\models\Order;
use yii\bootstrap\Button;

$this->title = 'Pedidos';
$this->params['breadcrumbs'][] = $this->title;

$query = Order::find();

$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        'defaultOrder' => [
            'id' => SORT_ASC
        ]
    ],
]);

// returns an array of Post objects
$orders = $provider->getModels();
?>

<div class="site-orders">
    <h1><?= Html::encode($this->title) ?></h1>

     <div class="row">
        <div class="col-lg-5">
            <?php
            
            echo Html::a('Nuevo Pedido', ['/site/neworder'], ['class'=>'btn btn-primary'])
            ?>
            <?php 
            	echo GridView::widget([
				    'dataProvider' => $provider,
				    'columns' => [
				        'id',
				        'user.username',
				        'date',
					    [
						    'class' => ActionColumn::className(),
						    'template' => '{vieworder} {deleteorder}',
							'buttons' => [
                                'vieworder' => function ($url,$model,$key) {
                                     return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                                },
								'deleteorder' => function ($url,$model,$key) {
						             return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
						        },
						    ],
						],
				    ]
				]);
			?>
        </div>
    </div>

</div>
