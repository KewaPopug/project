<?php

namespace app\controllers;

use app\models\Category;
use app\models\CollectionItem;
use app\models\CollectionItemSearch;
use app\models\Item;
use app\models\ItemSearch;
use app\modules\adminPanel\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CollectionItemController implements the CRUD actions for CollectionItem model.
 */
class CollectionItemController extends Controller
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

    /**
     * Lists all CollectionItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = CollectionItem::find()->all();
        $searchModel = new CollectionItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'model' =>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAccept($id, $action){
        if($action == 'Удаление'){
            $collNumbers = '';
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);
            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->active = 0;
                $item->save();
            }
            $model->delete();
            return $this->redirect(['index']);
        }


        if($action == 'Восстановление'){
            $collNumbers = '';
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);
            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->active = 1;
                $item->save();
            }
            $model->delete();
            return $this->redirect(['index']);
        }


        if($action == 'Смена материальноответсвенного'){
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);

            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                for ($i=0; $i < count($model->additional_data[0]); $i++){

                    if(isset($model->additional_data[0][$i][$item->id])){

                        $item->user_id = $model->additional_data[1];
                    }
                }

                $item->save();
            }

            $model->delete();
            return $this->redirect(['index']);
        }


        if($action == 'Смена корпуса/кабинета'){
            $collNumbers = '';
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);
            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->active = 0;
                $item->save();
            }
            $model->delete();
            return $this->redirect(['index']);
        }


        if($action == 'Удаление'){
            $collNumbers = '';
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);
            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->active = 0;
                $item->save();
            }
            $model->delete();
            return $this->redirect(['index']);
        }


        if($action == 'Удаление'){
            $collNumbers = '';
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);
            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->active = 0;
                $item->save();
            }
            return $this->redirect(['index']);
        }
    }



    /**
     * Displays a single CollectionItem model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $collNumbers = '';
        $model = $this->findModel($id);
        $items = json_decode($model->collection);
        foreach ($items as $item){
            if($collNumbers !== '') {
                $collNumbers .= ', ' . $item ;
            } else {
                $collNumbers=$item;
            }
        }
        return $this->render('view', [
            'items' => $collNumbers,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CollectionItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $searchModel = new ItemSearch();
        $categories = Category::find()->all();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        if(\Yii::$app->user->can('content_access') && !\Yii::$app->user->can('admin_access')) {
            $dataProvider->query->andWhere(['item.user_id' => \Yii::$app->user->id]);
        }
        return $this->render('create', [
            'categories' => $categories,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

//        $model = new CollectionItem();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
    }

    /**
     * Updates an existing CollectionItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CollectionItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionMultiChange($id, $status)
    {
        if($status == 0){
            $arr = array();
            if (Yii::$app->session->get('key') !== []){
                if(Yii::$app->session->get('key'))
                    $arr = Yii::$app->session->get('key');
                $arr[] = $id;
                Yii::$app->session->set('key', $arr);
            }else{
                Yii::$app->session->set('key', [$id]);
            }
        }else{
            ArrayHelper::removeValue($_SESSION['key'], $id);
            if (Yii::$app->session->get('key') == []){
                Yii::$app->session->destroy();
            }
        }
        $searchModel = new ItemSearch();
        $categories = Category::find()->all();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        if(\Yii::$app->user->can('content_access') && !\Yii::$app->user->can('admin_access')) {
            $dataProvider->query->andWhere(['item.user_id' => \Yii::$app->user->id]);
        }
        return $this->render('create', [
            'categories' => $categories,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMultiView()
    {
        $searchModel = new ItemSearch();
        $categories = Category::find()->all();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        if (\Yii::$app->user->can('content_access') && !\Yii::$app->user->can('admin_access')) {
            $dataProvider->query->andWhere(['item.user_id' => \Yii::$app->user->id]);
        }
        $keyList = Yii::$app->session->get('key');
        if ($keyList !== null){
            $dataProvider->query->andWhere(['item.id' => $keyList]);
        }
        if(Yii::$app->request->post('keyList')){
            $keyListFromJS = Yii::$app->request->post('keyList');
            $arrKey = explode(',', $keyListFromJS);
            $dataProvider->query->andWhere(['item.id' => $arrKey]);
        }
        Yii::$app->session->destroy('key');
        return $this->render('multi-view', [
            'categories' => $categories,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the CollectionItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CollectionItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CollectionItem::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
