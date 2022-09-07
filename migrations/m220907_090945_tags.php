<?php

use yii\db\Migration;

/**
 * Class m220907_090945_tags
 */
class m220907_090945_tags extends Migration
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

        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%post_tag_assn}}', [
            'post_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_post_id', '{{%post_tag_assn}}', 'post_id');
        $this->createIndex('idx_tag_id', '{{%post_tag_assn}}', 'tag_id');
        $this->addPrimaryKey('', '{{%post_tag_assn}}', ['tag_id', 'post_id']);
        $this->addForeignKey('fk_post_tag', '{{%post_tag_assn}}', 'tag_id', '{{%tag}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tag_post', '{{%post_tag_assn}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_tag_assn}}');
        $this->dropTable('{{%tag}}');
    }
}
