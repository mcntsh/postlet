<?php

namespace api\modules\v1\filters\auth;

use Yii;
use yii\filters\auth\AuthMethod;

class PostBodyAuth extends AuthMethod
{

  public $tokenParam = 'auth-key';

  public function authenticate($user, $request, $response)
  {
    $accessToken = $request->post($this->tokenParam);

    // Unset the token from the request
    $postBody = $request->getBodyParams();
    unset($postBody[$this->tokenParam]);
    $request->setBodyParams($postBody);

    if(is_string($accessToken)) {
      $identity = $user->loginByAccessToken($accessToken, get_class($this));

      if ($identity !== null) {
        return $identity;
      }
    }

    if($accessToken !== null) {
      $this->handleFailure($response);
    }

    return null;
  }

}
