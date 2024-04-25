<?php

namespace app\models;

class SubscriberModel extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return '{{%subscriptions}}';
	}
	
	public function rules()
	{
		return [
			[['user_id', 'subscriber_id'], 'required'],
		];
	}
}