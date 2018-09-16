<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\comments\widgets;

use gearsoftware\comments\models\Comment;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;

class CommentsForm extends \yii\base\Widget
{
    public $reply_to;
    private $_comment;
    public $title = '';

    public function init()
    {
        parent::init();

        if (!$this->_comment) {
            $this->_comment = new Comment(['scenario' => (Yii::$app->user->isGuest) ? Comment::SCENARIO_GUEST : Comment::SCENARIO_USER]);

            $post = Yii::$app->getRequest()->post();
            if ($this->_comment->load($post) && ($this->reply_to == ArrayHelper::getValue($post, 'Comment.parent_id'))) {
                $this->_comment->validate();
            }
        }

        if ($this->reply_to) {
            $this->_comment->parent_id = $this->reply_to;
        }
    }

    public function run()
    {
        if (Yii::$app->user->isGuest && empty($this->_comment->username)) {
            $this->_comment->username = HtmlPurifier::process(Yii::$app->getRequest()->getCookies()->getValue('username'));
        }

        if (Yii::$app->user->isGuest && empty($this->_comment->email)) {
            $this->_comment->email = HtmlPurifier::process(Yii::$app->getRequest()->getCookies()->getValue('email'));
        }

        return $this->render('form', [
        	'comment' => $this->_comment,
			'title' => $this->title,
        ]);
    }
}