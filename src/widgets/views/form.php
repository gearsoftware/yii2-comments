<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\comments\assets\CommentsAsset;
use gearsoftware\comments\Comments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gearsoftware\comments\models\Comment */
?>

<?php
\gearsoftware\assets\core\CoreAsset::register($this);
$commentsAsset = CommentsAsset::register($this);
Comments::getInstance()->commentsAssetUrl = $commentsAsset->baseUrl;

$col12 = Comments::getInstance()->gridColumns;
$col6 = (int) ($col12 / 2);

$formID = 'comment-form' . (($comment->parent_id) ? '-' . $comment->parent_id : '');
$replyClass = ($comment->parent_id) ? 'comment-form-reply' : '';
?>

<?php if (!$comment->parent_id): ?>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title"> <?= $title; ?></h3>
    </div>
    <div class="panel-body">

<?php endif; ?>
        <div class="media-block">
			<?php if (Comments::getInstance()->displayAvatar): ?>
                <a class="media-left">
                    <img class="img-circle img-<?= ($comment->parent_id) ? 'xs' : 'sm'; ?>" alt="Profile Picture" src="<?= Yii::$app->user->identity->getAvatar('large') ?>">
                </a>
			<?php endif; ?>
            <div class="media-body">

                <div class="comment-form <?= $replyClass ?>">

					<?php
					$form = ActiveForm::begin([
						'action' => NULL,
						'validateOnBlur' => FALSE,
						'validationUrl' => Url::to(['/' . Comments::getInstance()->commentsModuleID . '/validate/index']),
						'id' => $formID,
						'class' => 'com-form',
					]);

					if ($comment->parent_id) {
						echo $form->field($comment, 'parent_id')->hiddenInput()->label(false);
					}
					?>
                    <div class="comment-fields">

						<?= $form->field($comment, 'content')->textarea([
                            'rows' => ($comment->parent_id) ? 1 : 2,
							'class' => 'form-control input-sm',
							'placeholder' => Comments::t('comments', 'Share your thoughts...')
						])->label(false) ?>

                        <div class="comment-fields-more">
                            <div class="pull-right">
								<?= Html::button(Comments::t('comments', 'Cancel'), ['class' => 'btn btn-sm btn-default reply-cancel']) ?>
								<?= Html::submitButton('<i class="demo-psi-right-4 icon-fw"></i> '. (($comment->parent_id) ? Comments::t('comments', 'Reply') : Comments::t('comments', 'Post')), ['class' => 'btn btn-sm btn-primary']) ?>
                            </div>
                            <div class="fields">
                                <div class="row">
									<?php if (Yii::$app->user->isGuest): ?>
                                        <div class="col-lg-<?= $col6 ?>">
											<?= $form->field($comment, 'username', ['enableClientValidation' => false, 'enableAjaxValidation' => true])->textInput([
												'maxlength' => true,
												'class' => 'form-control input-sm',
												'placeholder' => Comments::t('comments', 'Your name')
											])->label(false) ?>
                                        </div>
                                        <div class="col-lg-<?= $col6 ?>">
											<?= $form->field($comment, 'email')->textInput([
												'maxlength' => true,
												'email' => true,
												'class' => 'form-control input-sm',
												'placeholder' => Comments::t('comments', 'Your email')
											])->label(false) ?>
                                        </div>
									<?php else: ?>
                                        <?php if(Comments::getInstance()->showReplyAs): ?>
                                            <div class="col-lg-<?= $col6 ?>">
                                                <?= (($comment->parent_id) ? Comments::t('comments', 'Reply as') : Comments::t('comments', 'Post as')) . ' <b>' . Yii::$app->user->identity->fullname . '</b>'; ?>
                                            </div>
										<?php endif; ?>
									<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

					<?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
<?php if (!$comment->parent_id): ?>
    </div>
</div>
<?php endif; ?>

<?php
//if (Yii::$app->getRequest()->post()) {
//$options    = Json::htmlEncode($form->getClientOptions());
//$attributes = Json::htmlEncode($form->attributes);
//\yii\widgets\ActiveFormAsset::register($this);
//$this->registerJs("jQuery('#$formID').yiiActiveForm($attributes, $options);");
//}
?>


