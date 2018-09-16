<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\comments\behaviors;

use gearsoftware\comments\widgets\Comments;
use yii\base\Behavior;

/**
 * Comments Behavior
 *
 * Render comments and form for owner model
 *
 */
class CommentsBehavior extends Behavior
{

    /**
     *
     * @return string the rendering result of the Comments Widget for owner model
     */
    public function displayComments()
    {
        return Comments::widget(['model' => $this->owner]);
    }
}