<?php

use yii\db\Migration;

class m160622_183010_order_lines extends Migration
{
    public function up()
    {
		$this->createTable('order_lines', [
			'id' => $this->primaryKey(),
			'order_id' => $this->integer(),
			'product_id' => $this->integer(),
			'quantity' => $this->integer()
			]);
		
		$this->createIndex(
            'idx-order_lines-order_id',
            'order_lines',
            'order_id'
        );
		
		$this->createIndex(
            'idx-order_lines-product_id',
            'order_lines',
            'product_id'
        ); 
		
		$this->addForeignKey(
            'fk-order_lines-order',
            'order_lines',
            'order_id',
            'orders',
            'id',
            'CASCADE'
        );
		
		$this->addForeignKey(
            'fk-order_lines-product',
            'order_lines',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
    	$this->dropForeignKey(
            'fk-order_lines-order',
            'order_lines'
        );
		
		$this->dropForeignKey(
            'fk-order_lines-product',
            'order_lines'
        );
		
		 $this->dropIndex(
            'idx-order_lines-order_id',
            'order_lines'
        );		
		
		 $this->dropIndex(
            'idx-order_lines-product_id',
            'order_lines'
        );
        $this->dropTable('order_lines');
    }
}
