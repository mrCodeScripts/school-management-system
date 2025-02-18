<?php

declare(strict_types=1);

/**
 * POST - create something
 * GET - read or fetch something
 * PUT - update or change something
 * DELETE - delete or remove something
 */

class Router
{
    private static $routers = [
        "POST" => [],
        "GET" => [],
        "PUT" => [],
        "DELETE" => []
    ];
    private static $globalMessage;
    private static $configurations;

    public static function init()
    {
        self::$globalMessage = null;
        self::$configurations = Config::getAllSettings();
    }

    public static function normalizePath(string $URI)
    {
        return rtrim($URI, "/");
    }

    public static function requestMethodValid(string $method)
    {
        return in_array($method, array_keys(self::$routers), true);
    }

    public static function pathExist(string $findRouterPath, $method)
    {
        $exists = false;
        foreach (self::$routers[$method] as $router) {
            if ($router["path"] === self::normalizePath($findRouterPath)) {
                $exists = true;
                break;
            }
        }
        return $exists;
    }

    public static function post(string $path, $callback, ...$midlewares): void
    {
        if (self::pathExist($path, "POST")) return;
        self::$routers["POST"][] = [
            "path" => self::normalizePath($path),
            "midlewares" => $midlewares,
            "callback" => $callback,
        ];
    }

    public static function put(string $path, $callback, ...$midlewares): void
    {
        if (self::pathExist($path, "PUT")) return;
        self::$routers["PUT"][] = [
            "path" => self::normalizePath($path),
            "midlewares" => $midlewares,
            "callback" => $callback,
        ];
    }

    public static function delete(string $path, $callback, ...$midlewares): void
    {
        if (self::pathExist($path, "DELETE")) return;
        self::$routers["DELETE"][] = [
            "path" => self::normalizePath($path),
            "midlewares" => $midlewares,
            "callback" => $callback,
        ];
    }

    public static function get(string $path, $callback, ...$midlewares): void
    {
        if (self::pathExist($path, "GET")) return;
        self::$routers["GET"][] = [
            "path" => self::normalizePath($path),
            "midlewares" => $midlewares,
            "callback" => $callback,
        ];
    }

    public static function getAllRouters()
    {
        print_r(self::$routers);
    }

    public static function dispatch(string $URI, string $requestMethod)
    {
        if (!in_array(strtoupper($requestMethod), array_keys(self::$routers))) echo "testing";
        $found = false;
        foreach (self::$routers[$requestMethod] as $router) {
            $findPath = self::normalizePath($URI);
            $foundPath = self::normalizePath($router["path"]);
            if ($findPath === $foundPath) {
                if (!is_callable($router["callback"])) return;
                !empty($router["midlewares"]) ?
                    $router["callback"](...$router["midlewares"]) :
                    $router["callback"]();
                $found = true;
                break;
            } else {
                $found = false;
            }
        }
        if ($found === true) {
            return;
        } else {
            http_response_code(404);
            include __DIR__ . "/../src/View/err.page.template/404.html";
            exit();
        }
    }
}
