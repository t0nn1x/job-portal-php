<?php

namespace Framework;

use Exception;
use PDO;
use PDOException;


class Database
{
    public $conn;

    /**
     * Constructor for Database class
     * 
     * @param array $config
     */
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};
            port={$config['port']};
            dbname={$config['dbname']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->conn = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $options
            );
        } catch (PDOException $e) {
            throw new Exception("Database connection failed:
                          {$e->getMessage()}");
        }
    }

    /**
     * Query the db
     * 
     * @param string $query
     * @return PDOStatement
     * @throws PDOException
     */
    public function query($query, $params = [])
    {
        try {
            $sth = $this->conn->prepare($query);

            // Check if parameters are associative (named) or sequential (positional)
            if ($this->isAssoc($params)) {
                // Bind named parameters
                foreach ($params as $param => $value) {
                    if (is_int($value)) {
                        $paramType = PDO::PARAM_INT;
                    } elseif (is_bool($value)) {
                        $paramType = PDO::PARAM_BOOL;
                    } elseif (is_null($value)) {
                        $paramType = PDO::PARAM_NULL;
                    } else {
                        $paramType = PDO::PARAM_STR;
                    }
                    $sth->bindValue(':' . $param, $value, $paramType);
                }
            } else {
                // Bind positional parameters
                foreach ($params as $index => $value) {
                    if (is_int($value)) {
                        $paramType = PDO::PARAM_INT;
                    } elseif (is_bool($value)) {
                        $paramType = PDO::PARAM_BOOL;
                    } elseif (is_null($value)) {
                        $paramType = PDO::PARAM_NULL;
                    } else {
                        $paramType = PDO::PARAM_STR;
                    }
                    // Note: PDO index is 1-based, so need to add 1
                    $sth->bindValue($index + 1, $value, $paramType);
                }
            }

            $sth->execute();
            return $sth;
        } catch (PDOException $e) {
            throw new Exception("Query failed to execute: {$e->getMessage()}");
        }
    }

    /**
     * Helper method to check if an array is associative.
     *
     * @param array $arr
     * @return bool Returns true if associative, false otherwise.
     */
    private function isAssoc(array $arr)
    {
        if ([] === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
