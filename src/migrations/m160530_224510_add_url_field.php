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

class m160530_224510_add_url_field extends Migration
{
    const TABLE_NAME = '{{%comment}}';
    
    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'url', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'url');
    }
}