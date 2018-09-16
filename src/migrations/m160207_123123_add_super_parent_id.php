<?php

/**
 * @package   Yii2-Comments
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use yii\db\Migration;

class m160207_123123_add_super_parent_id extends Migration
{
    const TABLE_NAME = '{{%comment}}';
    
    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'super_parent_id', $this->integer()->comment('null-has no parent, int-1st level parent id'));
        $this->createIndex('comment_super_parent_id', self::TABLE_NAME, 'super_parent_id');
    }

    public function down()
    {
        $this->dropIndex('comment_super_parent_id', self::TABLE_NAME);
        $this->dropColumn(self::TABLE_NAME, 'super_parent_id');
    }
}