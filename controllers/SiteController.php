<?php

namespace app\controllers;

use app\models\UploadForm;
use app\models\XlsData;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            //$model->xlsFiles = UploadedFile::getInstances($model, 'xlsFiles');
            $model->xlsFile = UploadedFile::getInstance($model, 'xlsFile');
            $model->parseAndSaveData();
            // file is uploaded successfully
            $json = json_encode($model->uploadedFileInfo);
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_RAW;
            $response->getHeaders()->set('Content-Type', 'application/json');
            return $json;
        }
        return $this->render('index', ['model' => $model]);
    }


    public function actionDisplay()
    {
        $arrayTree = XlsData::createArrayTree();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrayTree,
        ]);
        return $this->render('display', [
            'dataProvider' => $dataProvider,
            /*'playlist' => $playlist,*/
        ]);
    }


}
