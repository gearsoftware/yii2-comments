<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\comments\Comments;
use gearsoftware\comments\models\Comment;
use gearsoftware\comments\widgets\CommentsForm;
use gearsoftware\widgets\TimeAgo;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

\gearsoftware\assets\core\CoreAsset::register($this);
?>
<div class="panel">
    <div class="panel-body">
        <div class="media-block">
	        <?php if (Comments::getInstance()->displayAvatar): ?>
                <a class="media-left"><img class="img-circle img-sm" alt="Profile Picture" src="<?= $model->author->getAvatar('large'); ?>"></a>
	        <?php endif; ?>
            <div class="media-body">
                <div>
	                <?= Yii::t('core/media', 'Posted by') ?>
                    <a class="btn-link text-semibold media-heading box-inline"><?= Html::encode($model->author->fullname); ?></a>
                    <p>
                        <span class="text-muted">
                            <i class="ti-time icon-lg"> </i>
	                        <?= TimeAgo::widget(['timestamp' => $model->created_at, 'showDateTime' => true]); ?>
                        </span>
                    </p>
                </div>
                <p>
	                <?= Html::encode($model->content); ?>
                </p>
	            <?php if (!empty($model->comments) && $model->hasReplies()) : ?>
                    <div class="mar-top bord-top">
	                    <?php $nested_level++; ?>
	                    <?php foreach ($model->comments as $subcomment) : ?>
                            <?php if ($subcomment->isActive()) :?>
                                <div class="media sub-comment">
                                    <a class="media-left"><img class="img-circle img-xs" alt="Profile Picture" src="<?= $subcomment->author->getAvatar('large'); ?>"></a>
                                    <div class="media-body">
                                        <div>
                                            <a class="btn-link text-semibold media-heading box-inline"><?= Html::encode($subcomment->author->fullname); ?></a>
                                            <small class="text-muted pad-lft">
                                                <i class="ti-time icon-lg"> </i>
                                                <?= TimeAgo::widget(['timestamp' => $subcomment->created_at, 'showDateTime' => true]); ?>
                                            </small>
                                        </div>
                                        <?= Html::encode($subcomment->content); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
	                    <?php endforeach; ?>
                    </div>
	            <?php endif; ?>
                <div class="comment-footer">
		            <?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
                        <a class="btn-link text-semibold media-heading box-inline reply-button" data-reply-to="<?= $model->id; ?>" href="#">
				            <?= Comments::t('comments', 'Reply') ?>
                        </a>
		            <?php endif; ?>
                </div>
	            <?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
                    <div class="reply-form">
			            <?php if ($model->id == ArrayHelper::getValue(Yii::$app->getRequest()->post(), 'Comment.parent_id')) : ?>
				            <?= CommentsForm::widget(['reply_to' => $model->id]); ?>
			            <?php endif; ?>
                    </div>
	            <?php endif; ?>
            </div>
        </div>
    </div>
</div>



