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
use gearsoftware\comments\widgets\CommentsForm;

?>

<?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
    <?= CommentsForm::widget(compact('reply_to')) ?>
<?php endif; ?>