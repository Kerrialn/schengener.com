<?php

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

dd($_SERVER['APP_DEBUG_TOKEN'] === $_COOKIE['XDEBUG_TRACE']);

$trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false;
$trustedProxies = $trustedProxies ? explode(',', $trustedProxies) : [];
if ($_SERVER['APP_ENV'] == 'prod') $trustedProxies[] = $_SERVER['REMOTE_ADDR'];
if ($trustedProxies) {
    Request::setTrustedProxies($trustedProxies, Request::HEADER_X_FORWARDED_AWS_ELB);
}

if ($_SERVER['APP_ENV'] == 'prod' && $_SERVER['APP_DEBUG_TOKEN'] === $_COOKIE['XDEBUG_TRACE']) {
    umask(0000);
    Debug::enable();
    $_SERVER['APP_DEBUG'] = 1;
}

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
};
