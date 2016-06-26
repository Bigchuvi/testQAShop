<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Order_line;

/**
 * ProductForm is the model behind the contact form.
 */
class OrderlineForm extends Model
{
	public $id;
    public $order_id;
    public $product_id;
    public $quantity;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, unit_price, stock are required
            [['order_id','product_id', 'quantity'], 'required'],
        ];
    }
	
	public function saveOrderline()
    {
        if (!$this->validate()) {
            return null;
        }
        $orderline = Order_line::findOne($this->id);
        if($orderline === null){
            $orderline = new Order_line();
        }
        $orderline->order_id = $this->order_id;
        $orderline->product_id = $this->product_id;
        $orderline->quantity = $this->quantity;
        if($orderline->save()){
            return $orderline;
        }
        return null;
    }
}
