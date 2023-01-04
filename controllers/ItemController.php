<?php

namespace app\controllers;

use app\models\Cabinet;
use app\models\Category;
use app\models\Corps;
use app\models\Item;
use app\models\ItemSearch;
use app\modules\adminPanel\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionCabinets()
    {
        if (isset($_POST['id'])) {
            $cabinets = Cabinet::find()->where(['corps_id' => $_POST['id']])->all();
            echo "<option>Выбрать</option>";
            foreach ($cabinets as $cabinet) {
                echo "<option value='" . $cabinet->id . "'>" . $cabinet->cabinet . "</option>";
            }
        }
    }
    
    /**
     * Lists all Item models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Item();
        $modelCabinet = new Cabinet();
        $categories = Category::find()->all();
        $corps = Corps::find()->all();
        $cabinets = Cabinet::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'modelCabinet' =>  $modelCabinet,
            'categories' => $categories,
            'cabinets' => $cabinets,
            'corps' => $corps,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $modelCabinet = new Cabinet();
        $categories = Category::find()->all();
        $corps = Corps::find()->all();
        $cabinets = Cabinet::find()->all();
        $users = User::find()->where(['id' =>  ArrayHelper::merge(Yii::$app->authManager->getUserIdsByRole('admin'),Yii::$app->authManager->getUserIdsByRole('content'))])->all();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->user_id =
                $_POST["Item"]['user_id'];
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model->errors);
                die;
            }
        }

        return $this->render('update', [
            'modelCabinet' =>  $modelCabinet,
            'categories' => $categories,
            'cabinets' => $cabinets,
            'corps' => $corps,
            'model' => $model,
            'users' => $users,
        ]);
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
