<?php

namespace app\modules\adminPanel\controllers;

use app\models\History;
use app\models\Item;
use app\modules\adminPanel\models\form\ChangePassword;
use app\modules\adminPanel\models\form\Login;
use app\modules\adminPanel\models\form\ResetPassword;
use app\modules\adminPanel\models\form\Signup;
use app\modules\adminPanel\models\searchs\User as UserSearch;
use app\modules\adminPanel\models\TransferItem;
use app\modules\adminPanel\models\User;
use mdm\admin\components\UserStatus;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\mail\BaseMailer;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * User controller
 */
class UserController extends Controller
{
    private $_oldMailPath;
    /**
     * @var mixed
     */
//    private $email;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'logout' => ['post'],
                    'activate' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->has('mailer') && ($mailer = Yii::$app->getMailer()) instanceof BaseMailer) {
                /* @var $mailer BaseMailer */
                $this->_oldMailPath = $mailer->getViewPath();
                $mailer->setViewPath('@mdm/admin/mail');
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->_oldMailPath !== null) {
            Yii::$app->getMailer()->setViewPath($this->_oldMailPath);
        }
        return parent::afterAction($action, $result);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Login
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Logout
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    /**
     * Signup new user
     * @return string
     */
    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', [
                'model' => $model,
        ]);
    }

    /**
     * Request reset password
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionRequestPasswordReset($id)
    {
        try {
            $model = new ResetPassword($id);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionTransferItem($id)
    {
        $model = new User();
        $users = User::find()->where(['id' =>  ArrayHelper::merge(Yii::$app->authManager->getUserIdsByRole('admin'),Yii::$app->authManager->getUserIdsByRole('content'))])->all();
        $arr = [];

        $items = Item::find()->where(['user_id' => $id])->all();
//        var_dump($items);
//        die();

        if(ArrayHelper::getValue(Yii::$app->authManager->getAssignments($id), 'content') || ArrayHelper::getValue(Yii::$app->authManager->getAssignments($id), 'admin')){
            if ($this->request->isPost && $model->load(Yii::$app->getRequest()->post())) {
                foreach ($items as $item) {
//                    var_dump($item);
//                    die();
                    $templateProcessor = new TemplateProcessor('/var/www/project/file/transfer_template.docx');
                    $arr2 = [
                        'date' => date('d.m.y'),
                        'FIOfrom' => $item->user->profile->second_name . ' ' . $item->user->profile->first_name . ' ' .  $item->user->profile->middle_name,
                        'FIOto' => User::findOne(['id' => $_POST['User']['id']])->profile->second_name . ' ' . User::findOne(['id' => $_POST['User']['id']])->profile->first_name . ' ' . User::findOne(['id' => $_POST['User']['id']])->profile->middle_name,
                        'departmentFrom' => $item->user->profile->department,
                        'departmentTo' => User::findOne(['id' => $_POST['User']['id']])->profile->department,
                    ];
                    $templateProcessor->setValues($arr2);
                    $arr[] = [
                        'number_item' => $item->number_item,
                    ];
                    $templateProcessor->cloneRowAndSetValues('number_item', $arr);
                    $pathToSave = '/var/www/project/file/file1.docx';
                    $templateProcessor->saveAs($pathToSave);

                    $history = new History();
                    $history->item_id = $item->id;
                    $history->title = 'Переназначение материальнответственного';
                    $history->description = 'Переназначение материальнответственного с ' . $item->user->username
                    . ' на ' . User::findOne(['id' => $_POST['User']['id']])->username;
                    $history->save();

                    $item->user_id = (int)$_POST['User']['id'];
                    $item->save();
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('transfer', [
            'model' => $model,
            'users' => $users,
        ]);
    }

    /**
     * Reset password
     * @return string
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                'model' => $model,
        ]);
    }

    /**
     * Reset password
     * @return string
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            return $this->goHome();
        }

        return $this->render('change-password', [
                'model' => $model,
        ]);
    }

    /**
     * Activate new user
     * @param integer $id
     * @return type
     * @throws UserException
     * @throws NotFoundHttpException
     */
    public function actionActivate($id)
    {
        /* @var $user User */
        $user = $this->findModel($id);
        if ($user->status == UserStatus::INACTIVE) {
            $user->status = UserStatus::ACTIVE;
            if ($user->save()) {
                return $this->goHome();
            } else {
                $errors = $user->firstErrors;
                throw new UserException(reset($errors));
            }
        }
        return $this->goHome();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
