<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\comments\Comments as CommentsModule;
use gearsoftware\comments\Comments;
use gearsoftware\comments\components\CommentsHelper;
use gearsoftware\comments\models\Comment;
use gearsoftware\comments\widgets\CommentsForm;
use yii\timeago\TimeAgo;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model gearsoftware\comments\models\Comment */
$commentsPage = Yii::$app->getRequest()->get("comment-page", 1);
$cacheKey = 'comment' . $model . $model_id . $commentsPage;
$cacheProperties = CommentsHelper::getCacheProperties($model, $model_id);
?>
<div class="comments">
    <?php
        if ($this->beginCache($cacheKey . '-count', $cacheProperties)){
	        $allComments = Comments::t('comments', 'All Comments'). ' (' .Comment::activeCount($model, $model_id).')';
	        $this->endCache();
        }
    ?>

    <?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
        <div class="comments-main-form">
            <?= CommentsForm::widget([
                    'title' => $allComments
            ]); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->beginCache($cacheKey, $cacheProperties)) : ?>
        <?php
        Pjax::begin();

        echo ListView::widget([
            'dataProvider' => $dataProvider,
            //'emptyText' => CommentsModule::t('comments', 'No Comments'),
            'emptyText' => '',
            'itemView' => function ($model, $key, $index, $widget) {
                $nested_level = 1;
                return $this->render('comment', compact('model', 'widget', 'nested_level'));
            },
            'options' => ['class' => 'comments'],
            'itemOptions' => ['class' => 'comment'],
            'layout' => '{items}<div class="text-center">{pager}</div>',
            'pager' => [
	            'options' => [
		            'class' => 'pagination pagination-sm',
		            'style' => 'display: inline-block; margin: 9px 0 5px;',
	            ],
	            'hideOnSinglePage' => true,
	            'firstPageLabel' => '<<',
	            'prevPageLabel' => '<',
	            'nextPageLabel' => '>',
	            'lastPageLabel' => '>>',
	            'maxButtonCount' => 6
            ],
        ]);

        Pjax::end();

        $this->endCache();
        ?>
    <?php endif; ?>
</div>
