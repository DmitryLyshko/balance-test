<?php

namespace backend\controllers;

use frontend\models\Bill;
use frontend\models\Client;
use frontend\models\Costs;
use Yii;
use yii\base\Model;
use yii\db\StaleObjectException;
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
                        'actions' => ['logout', 'index', 'info', 'cost', 'bill', 'update'],
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
                'balance' => $balance->sum?: 0,
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
        $id = (int) Yii::$app->request->get('client');
        $costs = new Costs();
        if ($costs->load($this->dateToTimestamp(\Yii::$app->request->post(), 'Costs'))) {
            if ($costs->validate()) {
                $costs->save();
                $this->redirect(Url::to(["/info/{$id}"]));
            }
        }

        return $this->render('costform', ['model' => $costs, 'client_id' => $id]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionBill()
    {
        $id = (int) Yii::$app->request->get('client');
        $bill_id = (int) Yii::$app->request->get('bill');
        $bill = new Bill();

        $bill->load($this->dateToTimestamp(\Yii::$app->request->post(), 'Bill'));
        if ($bill->validate()) {
            $bill->save();
            return $this->redirect(Url::to(["/info/{$id}"]));
        }

        return $this->render('billform', ['model' => $bill, 'client_id' => $id, 'pay' => $bill_id]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        $id = (int) Yii::$app->request->get('client');
        $bill = Bill::findOne((int) Yii::$app->request->get('bill'));
        if (!$bill) {
            return $this->redirect(Url::to(["/info/{$id}"]));
        }

        $data = $this->dateToTimestamp(\Yii::$app->request->post(), 'Bill');

        if ($data !== []) {
            $bill->sum = $data['Bill']['sum'];
            $bill->type_id = $data['Bill']['type_id'];
            $bill->date_from = $data['Bill']['date_from'];
            $bill->date_to = $data['Bill']['date_to'];
        }

        if ($bill->validate()) {
            $bill->save();
            return $this->redirect(Url::to(["/info/{$id}"]));
        }

        return $this->render('updatebillform', ['model' => $bill, 'client_id' => $id]);
    }

    /**
     * @param array $data
     * @param string $model_name
     * @return array
     */
    private function dateToTimestamp(array $data = [], string $model_name): array
    {
        if ($data !== []) {
            foreach ($data[$model_name] as $key => $val) {
                if ($key === 'date_from' || $key === 'date_to') {
                    $date_time = new \DateTime($data[$model_name][$key]);
                    $data[$model_name][$key] = (string) $date_time->getTimestamp();
                }
            }
        }

        return $data;
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
