<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Product;

/**
 * ProductForm is the model behind the contact form.
 */
class ProductForm extends Model
{
	public $id;
    public $name;
    public $unit_price;
    public $stock;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, unit_price, stock are required
            [['name', 'unit_price', 'stock'], 'required'],
        ];
    }
	
	public function saveProduct()
    {
        if (!$this->validate()) {
            return null;
        }
        $product = Product::findOne($this->id);
        if($product === null){
            $product = new Product();
        }
        $product->name = $this->name;
        $product->unit_price = $this->unit_price;
        $product->stock = $this->stock;
        if($product->save()){
            return $product;
        }
        return null;
    }
}
