<?php

use yii\db\Migration;

/**
 * Class m220907_084152_post
 */
class m220907_084152_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%post_lang}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'title' => $this->string(),
            'text' => $this->text(),
        ], $tableOptions);

        $this->createIndex('idx_post_id', '{{%post_lang}}', 'post_id');
        $this->createIndex('idx_language', '{{%post_lang}}', 'language');
        $this->addForeignKey('fk_post_translation', '{{%post_lang}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_lang}}');
        $this->dropTable('{{%post}}');
    }
}
