<?php

namespace app\models;

use yii\db\ActiveRecord;

class TagModel extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tags}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Тег',
        ];
    }

    public function getPosts()
    {
        return $this->hasMany(PostModel::class, ['id' => 'post_id'])
            ->viaTable('post_tag', ['tag_id' => 'id']);
    }
}