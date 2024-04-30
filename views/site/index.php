<?php

/** @var yii\web\View $this */
/** @var yii\web\View $sort */
/** @var yii\web\View $posts */

$this->title = 'Главная';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4"><?=$this->title?></h1>
    </div>

    <div class="body-content">
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><?= $sort->link('title'); ?></th>
                    <th scope="col"><?= $sort->link('tags'); ?></th>
                    <th scope="col"><?= $sort->link('user_id'); ?></th>
                </tr>
                </thead>
                <tbody>
				<?php
				foreach ($posts as $post) {
					echo '
                    <tr>
                      <th scope="row">' . $post->id . '</th>
                      <td><a href="' . \yii\helpers\Url::to(['post/view', 'id' => $post->id]) . '">' . $post->title . '</a></td>
                      <td>' . $post->tags[0]['name'] . '</td>
                      <td>' . $post->user['username'] . '</td>
                    </tr>
                ';
				}
				?>
                </tbody>
            </table>
        </div>

    </div>
</div>
