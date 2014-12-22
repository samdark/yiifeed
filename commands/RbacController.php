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
        $auth = Yii::$app->authManager;

        $createNews = $auth->createPermission('createNews');
        $createNews->description = 'Create a news';
        $auth->add($createNews);

        $updateNews = $auth->createPermission('updateNews');
        $updateNews->description = 'Update news';
        $auth->add($updateNews);

        $addUserNews = $auth->createPermission('addUserNews');
        $addUserNews->description = 'User add news';
        $auth->add($addUserNews);

        $listNews = $auth->createPermission('listNews');
        $listNews->description = 'Show list news';
        $auth->add($listNews);

        $deleteNews = $auth->createPermission('deleteNews');
        $deleteNews->description = 'Delete news';
        $auth->add($deleteNews);

        $adminListNews = $auth->createPermission('adminListNews');
        $adminListNews->description = 'Show list news';
        $auth->add($adminListNews);

        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);
        $auth->addChild($user, $addUserNews);
        $auth->addChild($user, $listNews);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Модератор';
        $auth->add($moderator);
        $auth->addChild($moderator, $createNews);
        $auth->addChild($moderator, $updateNews);
        $auth->addChild($moderator, $listNews);
        $auth->addChild($moderator, $adminListNews);
        $auth->addChild($moderator, $deleteNews);

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);
        $auth->addChild($admin, $updateNews);
        $auth->addChild($admin, $moderator);
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