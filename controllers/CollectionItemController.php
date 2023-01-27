<?php

namespace app\controllers;

use app\models\CollectionItem;
use app\models\CollectionItemSearch;
use app\models\Item;
use app\modules\adminPanel\models\User;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            $collNumbers = '';
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);

            $items = Item::find()->andWhere(['id' => $itemsArr])->all();

            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->active = 0;
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
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CollectionItem();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CollectionItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
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
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
