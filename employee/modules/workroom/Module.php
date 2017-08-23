<?php

namespace employee\modules\workroom;

use Yii;
/**
 * workers module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'employee\modules\workroom\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->layout = '@employee/modules/workroom/views/layouts/main';
    }
}
