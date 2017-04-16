<?php
namespace api\modules\v1\controllers;

use Yii;

use api\modules\v1\components\ApiController;
use api\modules\v1\enums\ErrorEnum;
use api\modules\v1\enums\HttpEnum;

use yii\helpers\Json;

use common\models\Post;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

use api\modules\v1\filters\auth\PostBodyAuth;

class PostController extends ApiController
{

  public function behaviors()
  {
    $behaviors = parent::behaviors();

    $behaviors[] = [
      'class' => CompositeAuth::className(),
      'authMethods' => [
        ['class' => HttpBearerAuth::className()],
        [
          'class' => PostBodyAuth::className(),
          'tokenParam' => 'auth-key'
        ],
        [
          'class' => QueryParamAuth::className(),
          'tokenParam' => 'auth-key'
        ],
      ]
      // 'except' => ['view']
    ];

    return $behaviors;
  }

  // POST
  public function actionCreate() {
    $this->setResponseCode(HttpEnum::Created);

    $headers = Yii::$app->request->getHeaders();
    $payload = (object) Yii::$app->request->post();

    if(!$payload) {
      $this->addError('body', empty($rawPayload) ? ErrorEnum::Missing : ErrorEnum::Malformed);
      return $this->returnAndRespond(HttpEnum::BadRequest);
    }

    $userIp = Yii::$app->request->getUserIP();
    $userAgent = Yii::$app->request->getUserAgent();
    $userReferrer = Yii::$app->request->getReferrer();

    $post = new Post();
    $post->body = Json::encode($payload);
    $post->user_ip = $userIp;
    $post->user_agent = $userAgent;
    $post->user_referrer = $userReferrer;

    if(!$post->user_referrer) {
      $post->user_referrer = $headers->get('origin');
    }

    if($post->checkSpam()) {
      return $this->returnAndRespond(HttpEnum::Forbidden, 'This post was flagged as spam by our system');
    }

    if(!$post->save()) {
      $this->addModelErrors($post->getErrors());
      return $this->returnAndRespond(HttpEnum::Unprocessable);
    }

    return $post;
  }

  public function actionView($id)
  {
    $this->setResponseCode(HttpEnum::Ok);

    if(!$post = Post::findOne($id)) {
      return $this->returnAndRespond(HttpEnum::NotFound);
    }

    return $post;
  }

  public function actionDelete()
  {
    $this->setResponseCode(HttpEnum::Ok);

    if(!$post = Post::findOne($id)) {
      return $this->returnAndRespond(HttpEnum::NotFound);
    }

    if(!$post->delete()) {
      $this->addModelErrors($post->getErrors());
      return $this->returnAndRespond(HttpEnum::Unprocessable);
    }

    return $post;
  }

}
