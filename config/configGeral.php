<?php
function siteURL($sistema): string
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = "{$_SERVER['HTTP_HOST']}/$sistema";
    return $protocol.$domainName;
}
define('SERVERURL', siteURL("cursos/"));
define('PDFURL', SERVERURL."pdf/");
define('NOMESIS', "CURSOS");
define('SMTP', 'no.replay@teste.com');
define('SENHASMTP', 'senha');
date_default_timezone_set('America/Fortaleza');
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos