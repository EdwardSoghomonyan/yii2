<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Class m171226_051907_orders
 */
class m171226_051907_orders extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('orders', [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER,
            'price' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_STRING,
            'available' => 'tinyint(1) NOT NULL DEFAULT 0'
        ]);
    }
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('orders');
    }
}
