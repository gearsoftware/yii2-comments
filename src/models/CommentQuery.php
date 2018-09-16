<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\comments\models;

/**
 * This is the ActiveQuery class for [[Comment]].
 *
 * @see Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    private $_loadComments = false;

    public function active()
    {
        $this->andWhere(['status' => Comment::STATUS_PUBLISHED]);
        return $this;
    }

    public function getLoadComments()
    {
        return $this->_loadComments;
    }

    public function setLoadComments($loadComments)
    {
        $this->_loadComments = $loadComments;
    }

    /**
     * @inheritdoc
     * @return Comment[]|array
     */
    public function all($db = null)
    {
        $result = parent::all($db);

        if (!$this->loadComments) {
            return $result;
        }

        return $this->buildCommentsHierarchy($result);
    }

    protected function buildCommentsHierarchy($comments)
    {
        $ids = [];
        foreach ($comments as $model) {
            $ids[] = $model->id;
        }

        $parentsId = implode(',', $ids);
        $subComments = Comment::find()->where([
            'model' => $this->where['model'],
            'model_id' => $this->where['model_id'],
            'status' => Comment::STATUS_PUBLISHED,
        ]);

        if (!empty($parentsId)) {
            $subComments->where("super_parent_id IN ($parentsId)");
        }

        $subComments = $subComments->all();

        foreach ($comments as $parent) {
            $parent->comments = self::getSubComments($parent, $subComments);
        }

        return $comments;
    }

    protected static function getSubComments($parent, $comments)
    {
        $result = [];

        foreach ($comments as $comment) {

            if ($comment->parent_id === $parent->id) {
                $comment->comments = self::getSubComments($comment, $comments);
                $result[] = $comment;
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     * @return Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}