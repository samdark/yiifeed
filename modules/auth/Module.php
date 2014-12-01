<?php

namespace app\modules\auth;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\auth\controllers';
    public $defaultRoute = 'registration';

    public $tableMap = array(
        'User' => '{{%user}}',
    );

    public function __construct($id, $parent = null, $config = [])
    {
        if(is_array($config) AND count($config)>0)
        {
            foreach($config as $key=>$val)
            {
              if(isset($this->$key)) $this->$key = $val;
            }
        }
       parent::__construct($id, $parent, $config);
    }


    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

}
