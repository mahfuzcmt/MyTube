<?php
error_reporting(0);
header('Content-Type: application/json');
global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once '../videos/configuration.php';
}
require_once $global['systemRootPath'] . 'objects/user.php';
if (!User::canUpload() || empty($_POST['id'])) {
    die('{"error":"' . __("Permission denied") . '"}');
}
if (!is_array($_POST['id'])) {
    $_POST['id'] = [$_POST['id']];
}

require_once 'video.php';

$id = 0;
foreach ($_POST['id'] as $value) {
    $obj = new Video("", "", $value);
    if (empty($obj)) {
        die("Object not found");
    }
    if (!$obj->userCanManageVideo()) {
        $obj->msg = __("You can not Manage This Video");
        die(json_encode($obj));
    }
    $obj->setCategories_id($_POST['category_id']);
    $resp = $obj->save();
}
echo '{"status":"' . !empty($resp) . '"}';
