<?php

/** @var yii\web\View $this */

$this->title = 'Главная';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4"><?= $this->title ?></h1>
    </div>

    <div class="body-content">
        <div class="row">
            <?php
            foreach ($posts as $post) {
                echo '<div class="col-lg-4 mb-3">';
                echo '<h2><a href="' . \yii\helpers\Url::to(['post/view', 'id' => $post->id]) . '">' . $post->title . '</a></h2>';
                echo '<div><h5>' . $post->user['username'] . '</h5><h6>' . $post->tags[0]['name'] . '</h6></div>';
                echo '<p>' . $post->content . '</p>';
                echo '</div>';
            }
            ?>
        </div>

    </div>
</div>
