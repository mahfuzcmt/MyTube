<?php
class CloneLog
{
    public $file;

    public function __construct()
    {
        global $global;
        $clonesDir = Video::getStoragePath()."cache/clones/";
        $this->file = "{$clonesDir}client.log";
        if (!file_exists($clonesDir)) {
            mkdir($clonesDir, 0777, true);
            file_put_contents($clonesDir."index.html", '');
        }
        file_put_contents($this->file, "");
    }

    public function add($message)
    {
        _error_log($message);
        file_put_contents($this->file, $message.PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}
