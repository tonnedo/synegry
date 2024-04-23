<?php

namespace app\models;

use yii\db\ActiveRecord;

class PostModel extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%posts}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'content', 'public'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'title' => 'Название',
            'content' => 'Содержание',
            'public' => 'Публичный?',
        ];
    }

    public function getTags()
    {
        return $this->hasMany(TagModel::class, ['id' => 'tag_id'])
            ->viaTable('post_tag', ['post_id' => 'id']);
    }

    public function savePostWithTags($tags)
    {
        if ($this->validate()) {
            if ($this->save()) {
                foreach ($tags as $tagId) {
                    $tag = TagModel::findOne($tagId);
                    if ($tag) {
                        $this->link('tags', $tag);
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function savePost()
    {
        if ($this->validate()) {
            if ($this->save()) {
                return true;
            }
        }
        return false;
    }
}