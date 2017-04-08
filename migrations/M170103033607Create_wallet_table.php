<?php

namespace yuncms\wallet\migrations;

use yii\db\Migration;

/**
 * Class M170103033607Create_wallet_table
 * @package yuncms
 */
class M170103033607Create_wallet_table extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%wallet}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'currency' => $this->string(10)->notNull(),
            'money' => $this->decimal(10, 2)->defaultValue(0.00),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%wallet_log}}', [
            'id' => $this->primaryKey()->comment('自增ID'),
            'wallet_id' => $this->integer()->notNull()->comment('钱包ID'),
            'currency' => $this->string(10)->notNull(),
            'type' => $this->boolean()->defaultValue(false),
            'money' => $this->decimal(10, 2)->defaultValue(0.00)->comment('交易金额'),
            'action' => $this->string(),
            'msg' => $this->string(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('{{%wallet_log_ibfk_1}}', '{{%wallet_log}}', 'wallet_id', '{{%wallet}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%wallet_log_ibfk_2}}', '{{%wallet}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function safeDown()
    {
        $this->dropTable('{{%wallet_log}}');
        $this->dropTable('{{%wallet}}');
    }

}
