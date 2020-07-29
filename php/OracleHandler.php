<?php

namespace App\Library;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

/**
 * Class OracleHandler
 * @package App\Library
 */
class OracleHandler
{
    /**
     * @var resource
     */
    protected $connection;

    /**
     * OracleHandler constructor.
     */
    public function __construct()
    {
        $this->connection = $this->connect();
    }

    /**
     * Call oracle function with cache
     *
     * @param string $cacheKey
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function callWithCache(string $cacheKey, string $name, array $params = [])
    {
        $key = $this->getCacheKey($cacheKey, $name);

        return cache()->remember($key, Carbon::now()->addHour(), function () use ($name, $params) {
            return $this->call($name, $params);
        });
    }

    /**
     * Get cache key
     *
     * @param string $cacheKey
     * @param string $key
     * @return string
     */
    public function getCacheKey(string $cacheKey, string $key): string
    {
        return strtoupper($cacheKey) . strtoupper($key);
    }

    /**
     * Call Oracle function
     *
     * @param string $name
     * @param array $params
     * @return array|null
     * @throws Exception
     */
    public function call(string $name, array $params = []): ?array
    {
        $connect = $this->connection;

        $params['p_kalba_i'] = App::getLocale();
        $params['p_klaidos_id_o'] = null;
        $params['p_klaidos_tekst_o'] = null;

        /**
         * Create SQL from params
         */
        $sql = 'BEGIN :r := ' . $name . '(';
        $sql .= $this->formatSQL($params);

        /**
         * Prepare an Oracle statement for execution
         */
        $stmt = oci_parse($connect, $sql);

        foreach ($params as $key => $value) {
            oci_bind_by_name($stmt, ':' . $key, $params[$key], 50000);
        }

        /**
         * Bind answer to variable
         */
        $r = oci_new_descriptor($connect);
        oci_bind_by_name($stmt, ':r', $r, -1, OCI_B_CLOB);

        /**
         * Execute a statement
         */
        try {
            oci_execute($stmt);
        } catch (Exception $exception) {
            Log::channel('oralog')->warning($this->setErrorLogMessage($exception->getMessage(), $name, $params));
            throw new Exception(trans('app.database_error'));
        }

        return $r ? json_decode($r->load(), true) : $r;
    }

    /**
     * Connect to Oracle
     *
     * @return resource
     */
    protected function connect()
    {
        $connect = oci_connect(
            Config::get('database.connections.oracle.username'),
            Config::get('database.connections.oracle.password'),
            Config::get('database.connections.oracle.tns'),
            Config::get('database.connections.oracle.charset')
        );

        if (!$connect) {
            oci_error();
            oci_close($connect);
        }

        return $connect;
    }

    /**
     * Destruct connection
     */
    public function __destruct()
    {
        oci_close($this->connection);
    }

    /**
     * Format SQL
     *
     * @param array $params
     * @return string
     */
    protected function formatSQL(array $params): string
    {
        $sql = '';

        for ($i = 0; $i < \count($params); $i++) {
            if ($i == 0) {
                $sql .= ':' . array_keys($params)[$i];
            } else {
                $sql .= ', :' . array_keys($params)[$i];
            }
        }

        $sql .= '); end;';

        return $sql;
    }

    /**
     * Set oracle error log message
     *
     * @param string $exception
     * @param string $fnc
     * @param array $params
     * @return string
     */
    protected function setErrorLogMessage(string $exception, string $fnc, array $params): string
    {
        $message = PHP_EOL . 'user: [id: ' . Auth::user()->id
            . ', name: ' . Auth::user()->name
            . ', surname: ' . Auth::user()->surname . '];'
            . PHP_EOL . "fnc: [$fnc];"
            . PHP_EOL . 'params: [';

        foreach ($params as $param => $value) {
            $message .= "$param => " . ($value ?: 'null') . ', ';
        }

        return $message .= '];' . PHP_EOL . "message: [$exception];";
    }
}
