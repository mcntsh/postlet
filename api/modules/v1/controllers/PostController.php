<?php
namespace api\modules\v1\controllers;

use Yii;

use api\modules\v1\components\ApiController as ApiController;
use api\modules\v1\enums\ErrorEnum;
use api\modules\v1\enums\HttpEnum;

use yii\helpers\Json;

use yii\filters\VerbFilter;

use common\models\Post;

class PostController extends ApiController
{

  public function behaviors()
  {
    $behaviors = parent::behaviors();

    // $behaviors['verbFilter'] = [
    //   'class' => VerbFilter::className(),
    //   'actions' => [
    //     'index'  => ['get'],
    //   ]
    // ];

    return $behaviors;
  }

  public function actionIndex() {
    // ...
  }

  // POST
  public function actionCreate() {
    $this->setResponseCode(HttpEnum::Ok);

    try {
      $postPayload = Json::encode(Yii::$app->request->post());
    } catch(InvalidParamException $e) {
      $this->addError('body', ErrorEnum::Malformed);
      return $this->returnAndRespond(HttpEnum::BadRequest);
    }

    $post = new Post();
    $post->body = $postPayload;

    if(!$post->save()) {
      $this->addModelErrors($post->getErrors());
      return $this->returnAndRespond(HttpEnum::Unprocessable);
    }

    return $post;
  }

  public function actionView($id) {
    $this->setResponseCode(HttpEnum::Found);

    if(!$post = Post::findOne($id)) {
      return $this->returnAndRespond(HttpEnum::NotFound);
    }

    return $post;
  }

  public function actionUpdate() {
    $this->setResponseCode(HttpEnum::Ok);

  }

  public function actionDelete() {
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
