<?php

namespace app\modules\api;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        
        \Yii::configure($this, [
            'modules' => [
                'v1' => [
                    'class' => \app\modules\api\modules\v1\Module::class,
                ]   
            ]
        ]);
    }
    
}
