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
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);

            foreach ($itemsArr as $itemId) {
                $item = Item::findOne($itemId);
                $item->cabinet_id = $model->additional_data[0];
                $item->save();
            }
            $model->delete();
            return $this->redirect(['index']);
        }

        if($action == 'Смена категории'){
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);
            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->category_id = $model->additional_data[0];
                $item->save();
            }
            $model->delete();
            return $this->redirect(['index']);
        }

        if($action == 'Смена статуса'){
            $model = $this->findModel($id);
            $itemsArr = json_decode($model->collection);
            foreach ($itemsArr as $itemId){
                $item = Item::findOne($itemId);
                $item->status = $model->additional_data[0];
                $item->save();
            }
            $model->delete();
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
            'model' => $model
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
        $collNumbers = '';
        $model = $this->findModel($id);
        $items = json_decode($model->collection);
        $searchModel = new ItemSearch();
        $categories = Category::find()->all();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        $dataProvider->query->andWhere(['item.id' => $items]);

        if(\Yii::$app->user->can('content_access') && !\Yii::$app->user->can('admin_access')) {
            $dataProvider->query->andWhere(['item.user_id' => \Yii::$app->user->id]);
        }

        foreach ($items as $item){
            if($collNumbers !== '') {
                $collNumbers .= ', ' . $item ;
            } else {
                $collNumbers=$item;
            }
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'items' => $items,
            'categories' => $categories,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'collNumbers' => $collNumbers,
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
//        var_dump($_SESSION['collection'][0]);
//        die;
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

        if(isset($_SESSION['collection'])){
            return $this->render('update_add_delete', [
                'collectionId' => $_SESSION['collection'][0],
                'items' => (Yii::$app->session->get('key') != null) ? Yii::$app->session->get('key') : '',
                'categories' => $categories,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
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

    public function actionAddDeleteItems($collectionId)
    {
        $arr = array();
        if (Yii::$app->session->get('collection') !== []){
            if(Yii::$app->session->get('collection'))
                $arr = Yii::$app->session->get('collection');
            $arr[] = $collectionId;
            Yii::$app->session->set('collection', $arr);
        }else{
            Yii::$app->session->set('collection', [$collectionId]);
        }
        $_SESSION['collection'] = array_unique(Yii::$app->session->get('collection'));
//        ArrayHelper::removeValue($_SESSION['collection'], $collectionId);
//        if (Yii::$app->session->get('collection') == []){
//            Yii::$app->session->destroy();
//        }

        $arrKey = explode(',', $_POST['items']);
        foreach ($arrKey as $key){
            $arr = array();
            if (Yii::$app->session->get('key') !== []) {
                if (Yii::$app->session->get('key'))
                    $arr = Yii::$app->session->get('key');
                $arr[] = $key;
                Yii::$app->session->set('key', $arr);
            } else {
                Yii::$app->session->set('key', [$key]);
            }
        }
        $searchModel = new ItemSearch();
        $categories = Category::find()->all();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        if(\Yii::$app->user->can('content_access') && !\Yii::$app->user->can('admin_access')) {
            $dataProvider->query->andWhere(['item.user_id' => \Yii::$app->user->id]);
        }
        return $this->render('update_add_delete', [
            'collectionId' => (int)$collectionId,
            'items' => Yii::$app->session->get('key'),
            'categories' => $categories,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGoData()
    {
        $model = $this->findModel($_SESSION['collection'][0]);
        $items = json_decode($model->collection);
        $searchModel = new ItemSearch();
        $categories = Category::find()->all();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        $dataProvider->query->andWhere(['item.id' => $items]);
        var_dump($_SESSION['key']);
        die;
        if(Yii::$app->session->get('key') !== null ){
            $collectionItemModel = CollectionItem::findOne(['id' => $_SESSION['collection'][0]]);
            $collectionItemModel->collection = json_encode(Yii::$app->session->get('key'));
            $collectionItemModel->save();
//            var_dump($collectionItemModel->collection);
//            die();
            return $this->render('update', [
                'id' => $_SESSION['collection'][0],
                'items' => $items,
                'categories' => $categories,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
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
