<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\PostModel $postModel */

/** @var array $tagsData */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Редактировать пост';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('postFormSubmitted')): ?>

        <div class="alert alert-success">
            Пост успешно отредактирован
        </div>
    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'post-form']); ?>

                <?= $form->field($postModel, 'user_id')->textInput(['value' => Yii::$app->user->getId()]) ?>

                <?= $form->field($postModel, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($postModel, 'content')->textarea(['rows' => 6]) ?>

                <?= $form->field($postModel, 'public')->checkbox() ?>

                <?= $form->field($postModel, 'tagsData')->dropDownList($tagsData) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'post-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
