<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ProductForm;
use frontend\models\Product;
use frontend\models\Order;
use frontend\models\Order_line;
use frontend\models\OrderlineForm;

/**
 * Site controller
 */
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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

 
	/**
     * Displays product page.
     *
     * @return mixed
     */
    public function actionProducts()
    {
         $model = new ProductForm();
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($product = $model->saveProduct()) 
            {
            	Yii::$app->session->setFlash('success', 'The new product was created.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error creating the product.');
            }
           		return $this->refresh();
        } else {
                 return $this->render('products', [
                    'model' => $model,
                ]);
            }
    }
	
	public function actionDeleteproduct($id)
    {
         $model = Product::findOne($id);
		 if ($model !== null) {
            $model->deleteProduct();
          	return $this->redirect(['products']);
        } else {
          	return $this->redirect(['products']);
		}
    }
	
    
    public function actionDeleteorder_line($id)
    {
         $model = Order_line::findOne($id);
         $order = $model->order;
         if ($model !== null) {
            $model->delete();
            return $this->render('order_lines', [
                    'model' => $order
                ]);
        } else {
            return $this->render('orders');
        }
    }
    
    public function actionNeworder()
    {
         $model = new Order();
         $model->user_id = Yii::$app->user->getId();
         $model->date = date('Y-m-d H:i:s');
         $model->save();
         return $this->render('order_lines', [
                    'model' => $model,
                ]);
    }
    
    public function actionVieworder($id)
    {
         $model = Order::findOne($id);
         return $this->render('order_lines', [
                    'model' => $model
                ]);
    }

    public function actionAddproduct(){
        $model = new OrderlineForm();
        $model->load(Yii::$app->request->post());
        $model->saveOrderline();
        $order = Order::findOne($model->order_id);
         return $this->render('order_lines', [
                    'model' => $order
                ]);
    }
    
    public function actionDeleteorder($id)
    {
         $model = Order::findOne($id);
         if ($model !== null) {
            $model->delete();
            return $this->redirect(['orders']);
        } else {
            return $this->redirect(['orders']);
        }
    }
    
    
    public function actionOrders()
    {
         return $this->render('orders');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
