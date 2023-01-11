<?php

namespace app\controllers;

use app\models\Cabinet;
use app\models\Category;
use app\models\Corps;
use app\models\History;
use app\models\HistorySearch;
use app\models\Item;
use app\models\ItemSearch;
use app\modules\adminPanel\models\User;
use PhpOffice\PhpWord\TemplateProcessor;
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
        $categories = Category::find()->all();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        if(\Yii::$app->user->can('content_access') && !\Yii::$app->user->can('admin_access')) {
            $dataProvider->query->andWhere(['item.user_id' => \Yii::$app->user->id]);
        }
//        $dataProvider->query->andWhere(['item.active' => 1]);
        return $this->render('index', [
            'categories' => $categories,
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
        $_POST['item_id'] = $id;
        $histories = History::find();

        $searchModel = new HistorySearch();
        $dataProvider = $searchModel
            ->search($this->request->queryParams);
        $dataProvider->query->andWhere(['item_id' => $id]);
        $histories->andWhere(['item_id' => $id]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
                $history = new History();
                $history->item_id = $model->id;
                $history->title = 'Создание записи';
                $history->description = 'Создание записи';
                $history->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'modelCabinet' => $modelCabinet,
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
        $users = User::find()->where(['id' => ArrayHelper::merge(Yii::$app->authManager->getUserIdsByRole('admin'), Yii::$app->authManager->getUserIdsByRole('content'))])->all();

        if ($this->request->isPost) {
            if ($_POST["Item"]['category_id'] != $model->category_id) {
                $history = new History();
                $history->item_id = $_GET['id'];
                $history->title = 'Изменение предмета';
                $history->description = 'Изменение категории с ' . $model->category->category
                    . ' на ' . Category::findOne(['id' => $_POST['Item']['category_id']])->category;
                $history->save();
            }
            if ($_POST["Item"]['status'] != $model->status) {
                $history = new History();
                $history->item_id = $_GET['id'];
                $history->title = 'Изменение предмета';
                $history->description = 'Изменение статуса с ' . $model->status
                    . ' на ' . $_POST["Item"]['status'];
                $history->save();
            }
            if ($_POST["Item"]['name_item'] != $model->name_item) {
                $history = new History();
                $history->item_id = $_GET['id'];
                $history->title = 'Изменение предмета';
                $history->description = 'Изменение имени с ' . $model->name_item
                    . ' на ' . $_POST["Item"]['name_item'];
                $history->save();
            }
            if ($_POST["Item"]['number_item'] != $model->number_item) {
                $history = new History();
                $history->item_id = $_GET['id'];
                $history->title = 'Изменение предмета';
                $history->description = 'Изменение серийного номера с ' . $model->number_item
                    . ' на ' . $_POST["Item"]['number_item'];
                $history->save();
            }
            if ($_POST['corps'] != $model->cabinet->corps->corps) {
                $history = new History();
                $history->item_id = $_GET['id'];
                $history->title = 'Изменение предмета';
                $history->description = 'Изменение корпус с ' . $model->cabinet->corps->corps
                    . ' на ' . Corps::findOne(['id' => $_POST['corps']])->corps;
                $history->save();
            }
            if ($_POST["Item"]['cabinet_id'] != $model->cabinet) {
                $history = new History();
                $history->item_id = $_GET['id'];
                $history->title = 'Изменение предмета';
                $history->description = 'Изменение кабинет с ' . $model->cabinet->cabinet
                    . ' на ' . Cabinet::findOne(['id' => $_POST['Item']['cabinet_id']])->cabinet;
                $history->save();
            }
            if ($_POST["Item"]['user_id'] != $model->user_id) {
                $history = new History();
                $history->item_id = $_GET['id'];
                $history->title = 'Изменение предмета';
                $history->description = 'Переназначение материльноотвественного с ' . $model->user->username
                    . ' на ' . User::findOne(['id' => $_POST["Item"]['user_id']])->username;
                $history->save();
            }
        }
        if ($model->load($this->request->post())) {
            $model->user_id = $_POST["Item"]['user_id'];
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
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
        $model = $this->findModel($id);

        $history = new History();
        $history->item_id = $id;
        $history->title = 'Удаление предмета';
        $history->description = 'Удаление предмета';
        $history->save();

        $model->active = 0;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        $model->active = 1;
        $history = new History();
        $history->item_id = $id;
        $history->title = 'Восстановление предмета';
        $history->description = 'Восстановление предмета';
        $history->save();
        $model->save();
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
        if(Yii::$app->user->can('admin_access') && $model = Item::findOne(['id' => $id]))
        {
            return $model;
        }
        if (($model = Item::findItemById($id)))
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
