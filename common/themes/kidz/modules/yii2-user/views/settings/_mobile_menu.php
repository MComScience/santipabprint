<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/11/2561
 * Time: 20:22
 */
use kartik\icons\Icon;
use kidz\widgets\MobileMenu;

$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;
$action = Yii::$app->controller->action->id;
?>
<?php
echo MobileMenu::widget([
    'items' => [
        [
            'label' => Yii::t('user', 'หน้าแรก'),
            'icon' => Icon::show('home',['class' => 'fa-2x']),
            'url' => ['/site/index'],
        ],
        [
            'label' => Yii::t('user', 'Profile'),
            'icon' => Icon::show('user',['class' => 'fa-2x']),
            'url' => ['/user/settings/profile'],
            'active' => ($action == 'profile') ? true : false,
        ],
        [
            'label' => Yii::t('user', 'Account'),
            'icon' => Icon::show('address-card-o',['class' => 'fa-2x']),
            'url' => ['/user/settings/account'],
            'active' => ($action == 'account') ? true : false,
        ],
        [
            'label' => Yii::t('user', 'Networks'),
            'icon' => Icon::show('globe',['class' => 'fa-2x']),
            'url' => ['/user/settings/networks'],
            'active' => ($action == 'networks') ? true : false,
            'visible' => $networksVisible
        ],
    ],
    'options' => [
        'class' => 'hidden-lg hidden-md',
    ],
]);
?>
