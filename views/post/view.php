<?php

use yii\bootstrap5\Html;

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
    }
    ?>
</div>
