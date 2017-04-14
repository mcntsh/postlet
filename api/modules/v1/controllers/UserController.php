<?php
namespace app\modules\v1\controllers;

use yii\web\Controller;

class UserController extends Controller
{
  public function actionIndex()
  {
    echo 'Debugging: "d"';
    echo '<pre>';
    print_r("d");
    echo '</pre>';
    exit;
  }
}
