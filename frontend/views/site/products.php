<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use frontend\models\Product;

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;

$query = Product::find();

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
$products = $provider->getModels();
?>

<div class="site-products">
    <h1><?= Html::encode($this->title) ?></h1>

     <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'product-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model,'unit_price') ?>

                <?= $form->field($model,'stock') ?>		 

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'product-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            
            <?php 
            	echo GridView::widget([
				    'dataProvider' => $provider,
				    'columns' => [
				        'id',
				        'name',
				        'stock',
					    [
						    'class' => ActionColumn::className(),
						    'template' => '{deleteproduct}',
							'buttons' => [
								'deleteproduct' => function ($url,$model,$key) {
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
