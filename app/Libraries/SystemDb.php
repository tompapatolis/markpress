<?php namespace App\Libraries;

class SystemDb {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Count Records
 */

public function countRecords($table, $criteria='') {
    $builder = $this->db->table($table);

    if (!empty($criteria)) {
        $builder->where($criteria);
    }

    $count = $builder->countAllResults($column);
    return $count;
}

/**
 * Get Complete Table
 */

public function getTable($table, $orderBy='', $criteria='') {
    $builder = $this->db->table($table);

    if (!empty($criteria)) {
        $builder->where($criteria);
    }

    if (!empty($orderBy)) {
        $builder->orderBy($orderBy);
    }

    $results = $builder->get()->getResultArray();
    return $results;
}

/**
 * MySQL Date NOW()
 */

public function db_now() {
    return $this->db->query('SELECT NOW() as db_now')->getRow()->db_now;
}

/**
 * Return Array from DB Column
 */

public function db_get_column($table, $return_column, $criteria='') {
    $builder = $this->db->table($table);
    $builder->select($return_column);

    if (!empty($criteria)) {
        $builder->where($criteria);
    }

    $results = $builder->get()->getResultArray();
    $arr = array_column($results, $return_column);
    return $arr;
}

} // END Class