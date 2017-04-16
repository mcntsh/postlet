<?php

namespace common\models;

use Yii;

use common\models\BaseModel;
use common\behaviors\KeystampBehavior;

use yii\web\ServerErrorHttpException;

class Post extends BaseModel
{

  public static function tableName()
  {
    return '{{%posts}}';
  }

  public function behaviors()
  {
    $behaviors = parent::behaviors();

    $behaviors[] = ['class' => KeystampBehavior::className()];

    return $behaviors;
  }

  public function checkSpam()
  {
    $curl = curl_init();

    $apiUrl = 'https://' . Yii::$app->params['akismetAPIKey'] . '.rest.akismet.com/1.1/comment-check';

    $requestData  = 'blog=' . urlencode(Yii::$app->params['siteUrl']);
    $requestData .= '&user_ip=' . urlencode($this->user_ip);
    $requestData .= '&user_agent=' . urlencode($this->user_agent);
    $requestData .= '&referrer=' . urlencode($this->user_referrer);
    $requestData .= '&is_test=' . urlencode((int) Yii::$app->params['testMode']);

    curl_setopt_array($curl, array(
      CURLOPT_URL => $apiUrl,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $requestData,
      CURLOPT_HTTPHEADER => [
        'content-cength: ' . strlen($requestData),
        'content-type: application/x-www-form-urlencoded',
      ],
    ));

    $response = json_decode(curl_exec($curl));
    $err = curl_error($curl);

    curl_close($curl);

    if($err) {
      throw new ServerErrorHttpException('An error occured within the spam filter module');
    }

    return $response;
  }

}
