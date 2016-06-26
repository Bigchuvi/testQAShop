<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Order_line extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
     
     /*
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'order_lines';
    }
    
    
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
?>