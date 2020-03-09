<?php

namespace Source\Core\TotalTranslator;

use PDO;
use PDOException;

/**
 * Class ConnectTotal
 *
 */
class ConnectTotal
{
    /** @var PDO */
    private static PDO $instance;

    /** @var PDOException */
    private static PDOException $error;

    /**
     * @return PDO
     */
    public static function getInstance(): ?PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    DATA_LAYER_CONFIG_TOTAL["driver"] . ":host=" . DATA_LAYER_CONFIG_TOTAL["host"] . ";dbname=" . DATA_LAYER_CONFIG_TOTAL["dbname"] . ";port=" . DATA_LAYER_CONFIG_TOTAL["port"],
                    DATA_LAYER_CONFIG_TOTAL["username"],
                    DATA_LAYER_CONFIG_TOTAL["passwd"],
                    DATA_LAYER_CONFIG_TOTAL["options"]
                );
            } catch (PDOException $exception) {
                self::$error = $exception;
            }
        }

        return self::$instance;
    }


    /**
     * @return PDOException|null
     */
    public static function getError(): ?PDOException
    {
        return self::$error;
    }

    /**
     * Connect constructor.
     */
    final private function __construct()
    {
    }

    /**
     * Connect clone.
     */
    final private function __clone()
    {
    }
}