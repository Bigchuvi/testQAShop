<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use common\models\User;

class Order extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'orders';
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getOrder_lines()
    {
        return $this->hasMany(Order_line::className(), ['order_id' => 'id']);
    }
}
?>