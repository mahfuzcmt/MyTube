<?php

header('Content-Type: application/json');
require_once '../../../../videos/configuration.php';
require_once $global['systemRootPath'] . 'plugin/Live/Objects/Live_schedule.php';

$obj = new stdClass();
$obj->error = true;
$obj->msg = "";

$plugin = AVideoPlugin::loadPluginIfEnabled('Live');

if (!User::canStream()) {
    $obj->msg = "You cant do this";
    die(json_encode($obj));
}

if (empty($_POST['title'])) {
    $obj->msg = "invalid title";
    die(json_encode($obj));
}

if (empty($_POST['scheduled_time'])) {
    $obj->msg = "invalid date";
    die(json_encode($obj));
}

$o = new Live_schedule(@$_POST['id']);
$o->setTitle($_POST['title']);
$o->setDescription($_POST['description']);
//$o->setKey($_POST['key']);
$o->setUsers_id(User::getId());
$o->setLive_servers_id($_POST['live_servers_id']);
$o->setScheduled_time($_POST['scheduled_time']);
$o->setStatus($_POST['status']);
$o->setScheduled_password($_POST['scheduled_password']);
//$o->setPoster($_POST['poster']);
//$o->setPublic($_POST['public']);
//$o->setSaveTransmition($_POST['saveTransmition']);
//$o->setShowOnTV($_POST['showOnTV']);

if ($id = $o->save()) {
    $obj->msg = "{$_POST['title']} ".__('Saved');
    $obj->error = false;
} else {
    $obj->msg = __('Error on save')." {$_POST['title']}";
}



echo json_encode($obj);
