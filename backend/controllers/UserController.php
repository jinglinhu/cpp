<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $arrayStatus = User::getArrayStatus();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'arrayStatus' => $arrayStatus,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'admin-create']);

        $manager = Yii::$app->authManager;
        $allRoles = $manager->getRoles();
        $arrayRoles = [];

        if($allRoles){
            foreach ($allRoles as $key => $value) {
                $arrayRoles[$value -> name] = $value -> description;
            }
        }

        //判断当前用户是否为超级管理员，否则去处超级管理员权限
        $tmp = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        if($tmp){
            $isAdmin = false;
            foreach ($tmp as $key => $value) {
                if($value -> name == 'admin'){
                    $isAdmin = true;
                    break;
                }
            }
            if ($isAdmin === false){
                unset($arrayRoles['admin']);
            }
        }

        if ($model->load($post =Yii::$app->request->post()) && $model->save()) {

            $roles = isset($post['role'])?$post['role']:'';
            if($roles){
                foreach ($roles as $name) {
                    try {
                        $item = $manager->getRole($name);
                        $item = $item ? : $manager->getPermission($name);
                        $manager->assign($item, $model -> id);
                    } catch (\Exception $exc) {
                        $error[] = $exc->getMessage();
                    }
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'arrayRoles' => $arrayRoles,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('admin-update');
        $manager = Yii::$app->authManager;
        
        //获取所有权限列表
        $allRoles = $manager->getRoles();
        $arrayRoles = [];

        if($allRoles){
            foreach ($allRoles as $key => $value) {
                $arrayRoles[$value -> name] = $value -> description;
            }
        }

        //获取该修改用户列表
        $userRoles = $manager->getRolesByUser($id);
        $arrayUserRoles = [];
        if($userRoles){
            foreach ($userRoles as $key => $value) {
                $arrayUserRoles[] = $value -> name;
            }
        }

        //判断当前用户是否为超级管理员，否则去处超级管理员权限
        $tmp = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        if($tmp){
            $isAdmin = false;
            foreach ($tmp as $key => $value) {
                if($value -> name == 'admin'){
                    $isAdmin = true;
                    break;
                }
            }
            if ($isAdmin === false){
                unset($arrayRoles['admin']);
            }
        }

        if ($model->load($post = Yii::$app->request->post()) && $model->save()) {
            
            $roles = isset($post['role'])?$post['role']:'';
            $manager -> revokeAll($model -> id);

            if($roles){
                foreach ($roles as $name) {
                    try {
                        $item = $manager->getRole($name);
                        $item = $item ? : $manager->getPermission($name);
                        $manager->assign($item, $model -> id);
                    } catch (\Exception $exc) {
                        $error[] = $exc->getMessage();
                    }
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'arrayRoles' => $arrayRoles,
                'arrayUserRoles' => $arrayUserRoles,
            ]);
        }
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
