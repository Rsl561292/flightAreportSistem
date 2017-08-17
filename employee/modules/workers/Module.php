<?php

namespace employee\modules\workers;

/**
 * workers module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'employee\modules\workers\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->layout = '@employee/modules/workers/views/layouts/main';
        // custom initialization code goes here
    }
}
