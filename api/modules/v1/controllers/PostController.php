<?php
namespace api\modules\v1\controllers;

use Yii;

use api\modules\v1\components\ApiController;
use api\modules\v1\enums\ErrorEnum;
use api\modules\v1\enums\HttpEnum;

use yii\helpers\Json;

use common\models\Post;

use yii\filters\auth\HttpBearerAuth;

class PostController extends ApiController
{

  public function behaviors()
  {
    $behaviors = parent::behaviors();

    $behaviors['authenticator'] = [
      'class' => HttpBearerAuth::className(),
      'except' => ['view']
    ];

    return $behaviors;
  }

  // POST
  public function actionCreate() {
    $this->setResponseCode(HttpEnum::Created);

    $headers = Yii::$app->request->getHeaders();
    $payload = Yii::$app->request->post();

    if(!$payload) {
      $this->addError('body', empty($rawPayload) ? ErrorEnum::Missing : ErrorEnum::Malformed);
      return $this->returnAndRespond(HttpEnum::BadRequest);
    }

    $post = new Post();
    $post->body = Json::encode($payload);
    $post->request_origin = $headers->get('origin');

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
