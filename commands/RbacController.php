<?php
namespace app\commands;

use app\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        if (!$this->confirm("Are you sure? It will re-create permissions tree.")) {
            return self::EXIT_CODE_NORMAL;
        }

        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $adminNews = $auth->createPermission('adminNews');
        $adminNews->description = 'Administrate news';
        $auth->add($adminNews);

        $adminUsers = $auth->createPermission('adminUsers');
        $adminUsers->description = 'Administrate users';
        $auth->add($adminUsers);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);
        $auth->addChild($moderator, $adminNews);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $adminUsers);
    }

    public function actionAssign($role, $userId)
    {
        $user = User::findOne($userId);
        if (!$user) {
            throw new InvalidParamException('There is no such user.');
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($role);
        if (!$role) {
            throw new InvalidParamException('There is no such role.');
        }

        $auth->assign($role, $userId);
    }
}