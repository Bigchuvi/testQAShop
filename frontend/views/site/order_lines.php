<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\grid\ActionColumn;
use frontend\models\Order;
use frontend\models\Product;
use frontend\models\ProductForm;
use frontend\models\Order_line;
use frontend\models\OrderlineForm;
use yii\bootstrap\Button;

$this->title = 'Pedido #' . $model->id;
$this->params['breadcrumbs'][] = $this->title;

$query = Order_line::find();

$order_line = new OrderlineForm();

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

<div class="site-order_lines">
    <h1><?= Html::encode($this->title) ?></h1>

     <div class="row">
        <div class="col-lg-5">
            <?php
            
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',               
                        [                      // the owner name of the model
                            'label' => 'User',
                            'value' => $model->user->username,
                        ],
                        'date:datetime', // creation date formatted as datetime
                    ],
                ]);
            ?>          
            <?php $form = ActiveForm::begin(['id' => 'order_line-form','action' =>['site/addproduct']]); ?>

                <?php 
                     $items = ArrayHelper::map(Product::find()->all(), 'id', 'name');
                    
                ?>
                <?= Html::activeHiddenInput($order_line, 'order_id', ['value' => $model->id])  ?>
                <?= $form->field($order_line, 'product_id')->dropDownList($items) ?>
                <?= $form->field($order_line,'quantity') ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'order_line-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            
            
            <?php 
            	echo GridView::widget([
				    'dataProvider' => $provider,
				    'columns' => [
				        'id',
                        'order_id',
                        'product.name',
                        'quantity',
					    [
						    'class' => ActionColumn::className(),
						    'template' => '{deleteorder_line}',
							'buttons' => [
								'deleteorder_line' => function ($url,$model,$key) {
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
