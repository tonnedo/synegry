<?php

use yii\bootstrap5\Html;
use yii2mod\comments\widgets\Comment;

$this->title = 'Детальная поста';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <h2><?= $post->title ?></h2>
    <p><?= $post->content ?></p>
	
	<?php
	if (Yii::$app->user->getId() == $post->user_id) {
		echo Html::a('Редактировать', ['post/edit', 'id' => $post->id], ['class' => 'btn btn-primary']);
		echo Html::a('Удалить', ['post/delete', 'id' => $post->id], ['class' => 'btn btn-danger']);
	} else {
		$isSubscribe = null;
        if($isSubscribe = \app\models\SubscriberModel::findOne(['user_id' => $post->user_id, 'subscriber_id' => Yii::$app->user->getId()])) {
			echo Html::a('Отписаться', ['post/unsubscribe', 'user_id' => $post->user_id, 'subscriber_id' => Yii::$app->user->getId()], ['class' => 'btn btn-danger']);
		} else {
			echo Html::a('Подписаться', ['post/subscribe', 'user_id' => $post->user_id, 'subscriber_id' => Yii::$app->user->getId()], ['class' => 'btn btn-primary']);
		}
	}
    
    echo Comment::widget([
		'model' => $post,
	]);
	?>
</div>
