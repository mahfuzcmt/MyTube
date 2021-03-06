<?php

require_once dirname(__FILE__) . '/../../../videos/configuration.php';

class Meet_join_log extends ObjectYPT
{
    protected $id;
    protected $meet_schedule_id;
    protected $users_id;
    protected $ip;
    protected $user_agent;

    public static function getAllFromSchedule($meet_schedule_id)
    {
        global $global;
        if (!static::isTableInstalled()) {
            return false;
        }
        $meet_schedule_id = intval($meet_schedule_id);

        if (empty($meet_schedule_id)) {
            return false;
        }
        $sql = "SELECT u.*, ml.* FROM  " . static::getTableName() . " ml "
                . " LEFT JOIN users u ON u.id = ml.users_id "
                . "WHERE meet_schedule_id=$meet_schedule_id ";

        $sql .= self::getSqlFromPost();
        $res = sqlDAL::readSql($sql);
        $fullData = sqlDAL::fetchAllAssoc($res);
        sqlDAL::close($res);
        $rows = [];
        if ($res != false) {
            foreach ($fullData as $row) {
                $row = cleanUpRowFromDatabase($row);
                $rows[] = $row;
            }
        } else {
            die($sql . '\nError : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        }
        return $rows;
    }

    public static function getAllFromUser($users_id)
    {
        global $global;
        if (!static::isTableInstalled()) {
            _error_log("You need to install the meet plugin tables before use it", AVideoLog::$ERROR);
            return [];
        }
        $users_id = intval($users_id);

        if (empty($users_id)) {
            return false;
        }
        $sql = "SELECT me.*, ml.* FROM  " . static::getTableName() . " ml "
                . " LEFT JOIN meet_schedule me ON me.id = ml.meet_schedule_id "
                . "WHERE ml.users_id=$users_id ";

        $sql .= self::getSqlFromPost();
        $res = sqlDAL::readSql($sql);
        $fullData = sqlDAL::fetchAllAssoc($res);
        sqlDAL::close($res);
        $rows = [];
        if ($res != false) {
            foreach ($fullData as $row) {
                $rows[] = $row;
            }
        } else {
            die($sql . '\nError : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        }
        return $rows;
    }

    public static function getSearchFieldsNames()
    {
        return ['ip', 'user_agent'];
    }

    public static function getTableName()
    {
        return 'meet_join_log';
    }

    public static function getAllMeet_schedule()
    {
        global $global;
        $table = "meet_schedule";
        $sql = "SELECT * FROM {$table} WHERE 1=1 ";

        $sql .= self::getSqlFromPost();
        $res = sqlDAL::readSql($sql);
        $fullData = sqlDAL::fetchAllAssoc($res);
        sqlDAL::close($res);
        $rows = [];
        if ($res != false) {
            foreach ($fullData as $row) {
                $rows[] = $row;
            }
        } else {
            _error_log($sql . ' Error : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        }
        return $rows;
    }

    public static function getAllUsers()
    {
        global $global;
        $table = "users";
        $sql = "SELECT * FROM {$table} WHERE 1=1 ";

        $sql .= self::getSqlFromPost();
        $res = sqlDAL::readSql($sql);
        $fullData = sqlDAL::fetchAllAssoc($res);
        sqlDAL::close($res);
        $rows = [];
        if ($res != false) {
            foreach ($fullData as $row) {
                $rows[] = $row;
            }
        } else {
            _error_log($sql . ' Error : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        }
        return $rows;
    }

    public function setId($id)
    {
        $this->id = intval($id);
    }

    public function setMeet_schedule_id($meet_schedule_id)
    {
        $this->meet_schedule_id = intval($meet_schedule_id);
    }

    public function setUsers_id($users_id)
    {
        $this->users_id = intval($users_id);
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function setUser_agent($user_agent)
    {
        $this->user_agent = $user_agent;
    }

    public function getId()
    {
        return intval($this->id);
    }

    public function getMeet_schedule_id()
    {
        return intval($this->meet_schedule_id);
    }

    public function getUsers_id()
    {
        return intval($this->users_id);
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getUser_agent()
    {
        return $this->user_agent;
    }

    public static function log($meet_schedule_id)
    {
        $log = new Meet_join_log(0);
        $log->setIp(getRealIpAddr());
        $log->setMeet_schedule_id($meet_schedule_id);
        $log->setUser_agent((isMobile() ? "Mobile: " : ""). get_browser_name());
        $log->setUsers_id(User::getId());
        return $log->save();
    }

    public function save()
    {
        if (empty($this->users_id)) {
            $this->users_id = 'NULL';
        }

        return parent::save();
    }
}
