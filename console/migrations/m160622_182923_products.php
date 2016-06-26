<?php

use yii\db\Migration;

class m160622_182923_products extends Migration
{
    public function up()
    {
		$this->createTable('products', [
			'id' => $this->primaryKey(),
			'name' => $this->string()->notNull()->unique(),
			'unit_price' => $this->integer(),
			'stock' => $this->integer()
			]);
    }

    public function down()
    {
        $this->dropTable('products');
    }
}
