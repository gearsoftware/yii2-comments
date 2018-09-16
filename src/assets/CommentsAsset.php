<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\comments\assets;

use gearsoftware\comments\Comments;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;

class CommentsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/gearsoftware/yii2-comments/assets/source';
    public $css = [
        'css/comments.css',
    ];
    public $js = [
        'js/comments.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];

    /**
     * Registers this asset bundle with a view.
     * @param \yii\web\View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($view)
    {
        $commentsModuleID = Comments::getInstance()->commentsModuleID;
        $getFormLink = Url::to(["/$commentsModuleID/default/get-form"]);
        $js = <<<JS
commentsModuleID = "$commentsModuleID";
commentsFormLink = "$getFormLink";
JS;

        $view->registerJs($js, View::POS_HEAD);

        return parent::register($view);
    }
}