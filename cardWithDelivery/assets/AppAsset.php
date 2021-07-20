<?php

namespace app\modules\cardWithDelivery\assets;

use yii\web\AssetBundle;
use yii\bootstrap\BootstrapAsset;
use yii\web\YiiAsset;

class AppAsset extends AssetBundle
{
    public $baseUrl = '@web/../common-static/';
    public $css = ['css/web.css'];
    public $depends = [YiiAsset::class, BootstrapAsset::class];
}