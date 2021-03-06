<?php

require_once dirname(__FILE__) . '/../../../videos/configuration.php';

class Categories_has_users_groups extends ObjectYPT
{
    protected $id;
    protected $categories_id;
    protected $users_groups_id;
    protected $status;

    public static function getSearchFieldsNames()
    {
        return [];
    }

    public static function getTableName()
    {
        return 'categories_has_users_groups';
    }

    public static function getAllCategories()
    {
        global $global;
        $table = "categories";
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
    public static function getAllUsers_groups()
    {
        global $global;
        $table = "users_groups";
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

    public function setCategories_id($categories_id)
    {
        $this->categories_id = intval($categories_id);
    }

    public function setUsers_groups_id($users_groups_id)
    {
        $this->users_groups_id = intval($users_groups_id);
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function getId()
    {
        return intval($this->id);
    }

    public function getCategories_id()
    {
        return intval($this->categories_id);
    }

    public function getUsers_groups_id()
    {
        return intval($this->users_groups_id);
    }

    public function getStatus()
    {
        return $this->status;
    }


    public static function getAll()
    {
        global $global;
        if (!static::isTableInstalled()) {
            return false;
        }
        $sql = "SELECT c.*, ug.*, cug.* FROM  " . static::getTableName() . " cug "
                . " LEFT JOIN categories c ON cug.categories_id = c.id "
                . " LEFT JOIN users_groups ug ON cug.users_groups_id = ug.id "
                . " WHERE 1=1 ";

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

    public static function getAllFromCategory($categories_id)
    {
        global $global;
        if (!static::isTableInstalled()) {
            return false;
        }
        $categories_id = intval($categories_id);
        if (empty($categories_id)) {
            return false;
        }
        $sql = "SELECT c.*, ug.*, cug.* FROM  " . static::getTableName() . " cug "
                . " LEFT JOIN categories c ON cug.categories_id = c.id "
                . " LEFT JOIN users_groups ug ON cug.users_groups_id = ug.id "
                . " WHERE cug.categories_id = {$categories_id} ";

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
}
