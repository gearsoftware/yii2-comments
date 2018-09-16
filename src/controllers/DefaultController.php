<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\comments\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-form' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Render reply form by AJAX request
     *
     * @return string
     */
    public function actionGetForm()
    {
        $reply_to = (int)Yii::$app->getRequest()->post('reply_to');
        return $this->renderAjax('get-form', compact('reply_to'));
    }
}