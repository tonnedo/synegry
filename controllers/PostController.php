<?php

namespace app\controllers;

use app\models\PostModel;
use app\models\TagModel;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

class PostController extends \yii\web\Controller
{
    public function actionView($id)
    {
        $post = PostModel::findOne($id);

        if (!$post) {
            throw new NotFoundHttpException('Пост не найден');
        }

        return $this->render('view', [
            'post' => $post,
        ]);
    }

    public function actionDelete($id)
    {
        $post = PostModel::findOne($id);

        if (!$post) {
            throw new NotFoundHttpException('Пост не найден');
        }

        $post->delete();

        \Yii::$app->session->setFlash('success', 'Пост успешно удален');

        return $this->redirect(['site/index']);
    }

    public function actionEdit($id)
    {
        $post = PostModel::findOne($id);

        if (!$post) {
            throw new NotFoundHttpException('Пост не найден');
        }

        return $this->proceedModel($post);

//        return $this->render('edit', [
//            'post' => $post,
//        ]);
    }

    public function actionCreate()
    {
        $postModel = new PostModel();
        $tagModel = new TagModel();

        if ($postModel->load(\Yii::$app->request->post())) {
            if ($postModel->savePost()) {
                $tags = \Yii::$app->request->post('TagModel')['name'];
                $postModel->savePostWithTags($tags);
            }
        }

        return $this->render('create', [
            'postModel' => $postModel,
            'tagModel' => $tagModel,
        ]);
    }

    private function proceedModel(PostModel $model)
    {
        $request = \Yii::$app->request;

        if ($request->isAjax) {
            return $this->asJson(ActiveForm::validate($model));
        }

        if ($model->load($request->post())) {
            if ($model->validate() && $model->savePost()) {
                $tags = \Yii::$app->request->post('PostModel')['tagsData'];
                $model->savePostWithTags($tags);

                \Yii::$app->session->setFlash('success', 'Пост успешно обновлен');
                return $this->redirect(['edit', 'id' => $model->id]);
            }
        }

        $model->setTagsDropdownData($model, 'tagsData');

        return $this->render('edit', [
            'postModel' => $model,
            'tagsData' => TagModel::find()
                ->select('name')
                ->indexBy('id')
                ->column()
        ]);
    }
}