<?php

use yii\db\Migration;

class m160622_182901_users extends Migration
{
    public function up()
    {
		$this->createTable('users', [
			'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
			]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
