<?php
namespace api\modules\v1\controllers;

use Yii;

use api\modules\v1\components\ApiController as ApiController;
use api\modules\v1\enums\ErrorEnum;

use common\models\Post;

class UserController extends ApiController
{

  public function actionIndex()
  {

    Post::test();

    $this->addError('token', ErrorEnum::Invalid, 'The auth token is invalid');
    $this->setResponseError(403);
  }

}
