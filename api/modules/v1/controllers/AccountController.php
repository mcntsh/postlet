<?php
namespace api\modules\v1\controllers;

use Yii;

use api\modules\v1\components\ApiController;
use api\modules\v1\enums\ErrorEnum;
use api\modules\v1\enums\HttpEnum;

use yii\helpers\Json;

use common\models\Account;

class AccountController extends ApiController
{

  // POST
  public function actionCreate()
  {
    $this->setResponseCode(HttpEnum::Created);

    $payload = (object) Yii::$app->request->post();

    if(Account::findByEmail($payload->email)) {
      $this->addError('email', ErrorEnum::Exists, 'An account with this email is already registered.');
      return $this->returnAndRespond(HttpEnum::Conflict);
    }

    $account = new Account();
    $account->email = $payload->email;
    $account->password = $account->setPassword($payload->password);
    $account->auth_key = $account->generateAuthKey();

    if(!$account->save()) {
      $this->addModelErrors($account->getErrors());
      return $this->returnAndRespond(HttpEnum::Unprocessable);
    }

    return $account;
  }

  public function actionView($id)
  {
    $this->setResponseCode(HttpEnum::Ok);

    if(!$account = Account::findOne($id)) {
      return $this->returnAndRespond(HttpEnum::Conflict);
    }

    return $account;
  }

}
