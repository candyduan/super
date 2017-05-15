<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);

$composerAutoload = [
    __DIR__ . '/vendor/autoload.php', // in yii2-dev repo
];
$vendorPath = null;
foreach ($composerAutoload as $autoload) {
    if (file_exists($autoload)) {
        require($autoload);
        $vendorPath = dirname($autoload);
        break;
    }
}

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../common/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../common/config/main.php'),
	require(__DIR__ . '/../console/config/main.php')
);

$application = new yii\console\Application($config);
if ($vendorPath !== null) {
    $application->setVendorPath($vendorPath);
}

$exitCode = $application->run();
exit($exitCode);
