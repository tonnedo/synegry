<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_tag}}`.
 */
class m240423_193453_create_post_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_tag', [
            'post_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'PRIMARY KEY(post_id, tag_id)',
        ]);

        $this->addForeignKey('fk-post_tag-post_id', 'post_tag', 'post_id', 'posts', 'id', 'CASCADE');
        $this->addForeignKey('fk-post_tag-tag_id', 'post_tag', 'tag_id', 'tags', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_tag}}');
    }
}
