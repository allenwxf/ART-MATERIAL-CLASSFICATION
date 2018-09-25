<?php
/**
 * Created by PhpStorm.
 * User: wangxufeng
 * Date: 2018/9/3
 * Time: 18:09
 */
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class QiuqiuArtController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // $mlApi = "http://192.168.116.214:9091/artMaterialVefi";
        $mlApi = "http://192.168.116.214:9091/tf_serving";
        $artUrl = "http://192.168.116.214:9090/images/art/";
        $targetUrl = "http://192.168.116.214:9090/images/target/";
        return $this->render('index', ["mlApi" => $mlApi, "artUrl" => $artUrl, "targetUrl" => $targetUrl]);
    }
}