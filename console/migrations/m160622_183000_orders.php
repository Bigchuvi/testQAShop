<?php

use yii\db\Migration;

class m160622_183000_orders extends Migration
{
    public function up()
    {
		$this->createTable('orders', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer(),
			'date' => $this->dateTime()
			]);
		
		$this->createIndex(
            'idx-orders-user_id',
            'orders',
            'user_id'
        );
		
		$this->addForeignKey(
            'fk-orders-user',
            'orders',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
		
    }

    public function down()
    {
    	$this->dropForeignKey(
            'fk-orders-user',
            'orders'
        );
		
		 $this->dropIndex(
            'idx-orders-user_id',
            'orders'
        );
		
        $this->dropTable('orders');
    }
}
