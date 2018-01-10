<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->render('create', [
            'model' =>  new Orders(),
        ]);
    }

    public function actionStore()
    {
        $status = 'success';

        if(Yii::$app->request->post('Orders')) {
            foreach (Yii::$app->request->post('Orders') as $orders) {
                $model = new Orders();

                if (!($model->load(['Orders'=>$orders]) && $model->save())) {
                    $status = 'error';
                    break;
                }
            }
        }

        return $status == 'success' ? $this->redirect(['update','id'=>$model->order_id]) : $this->redirect('create');
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $status = 'success';

        if(!empty(Yii::$app->request->post('Orders'))) {
            foreach (Yii::$app->request->post('Orders') as $newModel ) {
                $model = isset($newModel['id']) ?
                    $this->findModel($newModel['id']) :
                    new Orders();

                if (!($model->load(['Orders'=>$newModel]) && $model->save())) {
                    $status = 'error';
                    break;
                }
            }

            if(Yii::$app->request->post('removed_orders')) {
                $removedOrders = Yii::$app->request->post('removed_orders');
                $removedOrders = explode(',', $removedOrders);

                foreach ($removedOrders as $order) {
                    $model = $this->findModel($order);
                    $model->delete();
                }
            }
        }
        return $status !== 'success' ?
            $this->redirect(['index']) :
            $this->render(
                'update',
                [
                    'models' => Orders::find()->where('order_id = :order_id', ['order_id' => $id])->all(),
                    'order_id' => $id
                ]
            );
    }

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
