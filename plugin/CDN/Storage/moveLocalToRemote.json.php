<?php

$config = dirname(__FILE__) . '/../../../videos/configuration.php';
require_once $config;
session_write_close();
header('Content-Type: application/json');

$obj = new stdClass();
$obj->error = true;
$obj->msg = "";

$isEnabled = AVideoPlugin::isEnabledByName('CDN');
if (!$isEnabled) {
    $obj->msg = "CDN is disabled";
    die(json_encode($obj));
}

if (empty($_REQUEST['videos_id'])) {
    $_REQUEST['videos_id'] = intval(@$argv[1]);
}

if (empty($_REQUEST['videos_id'])) {
    $obj->msg = "Video ID is empty ";
    _error_log("{$obj->msg} ".json_encode($_REQUEST));
    die(json_encode($obj));
}
if (!is_array($_REQUEST['videos_id'])) {
    $_REQUEST['videos_id'] = [$_REQUEST['videos_id']];
}

_error_log('Start to move file ');
foreach ($_REQUEST['videos_id'] as $videos_id) {
    if (!isCommandLineInterface()) {
        if (!Video::canEdit($videos_id)) {
            $obj->error = true;
            $obj->msg = "Command line only";
            die(json_encode($obj));
        }
    }

    $obj->error = false;
    //$obj->response = CDNStorage::moveLocalToRemote($videos_id);
    $obj->response = CDNStorage::put($videos_id, 4);
}
_error_log('Finish to move file ');
echo json_encode($obj);
