<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

class PostModel extends ActiveRecord
{
    public $tagsData;

    public static function tableName()
    {
        return '{{%posts}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'content', 'public'], 'required'],
            [['tagsData'], 'safe']
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

    public function getUser()
    {
        return $this->hasOne(UserModel::class, ['id' => 'user_id']);
    }

    public function savePostWithTags($tag)
    {
        if ($this->validate()) {
            if ($this->save()) {
                \Yii::$app->db->createCommand()
                    ->delete('post_tag', ['post_id' => $this->id])
                    ->execute();

                $tagItem = TagModel::findOne($tag);
                if ($tagItem) {
                    $this->unlink('tags', $tagItem, true);
                    $this->link('tags', $tagItem);
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

    public function setTagsDropdownData(PostModel $model, string $fieldName): void
    {
        $postTag = (new Query)->from('post_tag')->where(['post_id' => $this->id])->all();

        foreach ($postTag as $tag) {
            $model->$fieldName[] = $tag['tag_id'];
        }
    }
}