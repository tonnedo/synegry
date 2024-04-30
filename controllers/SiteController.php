<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\PostModel;
use app\models\RegistrationForm;
use app\models\TagModel;
use Yii;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$sort = new Sort([
			'attributes' => [
				'title' => [
					'label' => 'Заголовок',
				],
				'user_id' => [
					'label' => 'Автор',
				],
				'tags' => [
					// Используем callable для сортировки по тегу
					'asc' => ['tags.name' => SORT_ASC],
					'desc' => ['tags.name' => SORT_DESC],
					// Подписываем атрибут для вывода в интерфейсе
					'label' => 'Тег',
					// Устанавливаем значение по умолчанию
					'default' => SORT_ASC,
				],
			],
		]);
		
        $posts = PostModel::find();
        if (Yii::$app->user->isGuest) {
            $posts = $posts->where(['public' => true]);
        }
        $posts = $posts
			->joinWith(['tags', 'user'])
			->orderBy($sort->orders)
			->all();

        return $this->render('index', [
            'posts' => $posts,
			'sort' => $sort,
        ]);
    }
	
	public function actionPosts()
	{
		$sort = new Sort([
			'attributes' => [
				'title' => [
					'label' => 'Заголовок',
				],
				'user_id' => [
					'label' => 'Автор',
				],
				'tags' => [
					// Используем callable для сортировки по тегу
					'asc' => ['tags.name' => SORT_ASC],
					'desc' => ['tags.name' => SORT_DESC],
					// Подписываем атрибут для вывода в интерфейсе
					'label' => 'Тег',
					// Устанавливаем значение по умолчанию
					'default' => SORT_ASC,
				],
			],
		]);
		
		$posts = PostModel::find()
			->innerJoin('subscriptions', 'posts.user_id = subscriptions.user_id')
			->where(['subscriptions.subscriber_id' => Yii::$app->user->getId()])
			->joinWith(['tags', 'user'])
			->orderBy($sort->orders)
			->all();
		
		return $this->render('index', [
			'posts' => $posts,
			'sort' => $sort,
		]);
	}

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegistration()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signUp()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }
}
