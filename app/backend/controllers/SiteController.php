<?php

namespace backend\controllers;

use app\models\Costs;
use frontend\models\Client;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'info', 'cost'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $client = new Client();
        if ($client->load(\Yii::$app->request->post())) {
            if ($client->validate()) {
                $client->save();
            }
        }

        return $this->render('index', ['model' => $client, 'clients' => $client::find()->all()]);
    }

    /**
     * Client info
     *
     * @return string
     */
    public function actionInfo()
    {
        $id = (int) Yii::$app->request->get('id');
        $client = Client::find()->where(['id' => $id])->one();

        $bills = [];
        $costs = [];
        $balance = new \stdClass();
        $balance->sum = 0;
        if ($client) {
            $balance = $client->getBalances()->one();
            $bills = $client->getBills()->all();
            $costs = $client->getCosts()->all();
        }

        return $this->render(
            'info',
            [
                'client' => $client,
                'balance' => $balance->sum,
                'bills' => $bills,
                'costs' => $costs
            ]
        );
    }

    /**
     * Add cost client
     *
     * @return string
     */
    public function actionCost()
    {
        $id = (int) Yii::$app->request->get('id');
        $costs = new Costs();
        $data = $costs->dateToTimestamp(\Yii::$app->request->post());
        if ($costs->load($data)) {
            if ($costs->validate()) {
                $costs->save();
                $this->redirect(Url::to(["/info/{$id}"]));
            }
        }

        return $this->render('costclient', ['model' => $costs, 'client_id' => $id]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
