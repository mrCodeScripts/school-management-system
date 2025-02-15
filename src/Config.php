<?php

declare(strict_types=1);

use Dotenv\Dotenv;

class Config
{
    private static $configurations = [];

    private function __construct() {}

    public static function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
        $dotenv->load();
    }

    public static function getAllSettings()
    {
        return self::$configurations;
    }

    public static function addSetting(string $settingName, mixed $settingValue)
    {
        self::$configurations[$settingName] = $settingValue;
    }

    public static function addFullSettings(array $settingsArray): void
    {
        self::$configurations = $settingsArray;
    }

    public static function getBuiltInSystemMsgs(): array | null
    {
        $modifiedMsg = [];
        $systemMsg = self::$configurations["system_messages"];
        foreach ($systemMsg as $msgName => $msg) {
            if (!isset($modifiedMsg[$msgName])) $modifiedMsg[$msgName] = [];
            if (is_array($msg)) {
                $modifiedMsg[$msgName]["messageName"] = $msgName;
                $modifiedMsg[$msgName]["message"] = [...$msg];
            } else {
                $modifiedMsg[$msgName]["messageName"] = $msgName;
                $modifiedMsg[$msgName]["message"] = $msg;
            }
        }
        return $modifiedMsg ?? null;
    }

    public static function generateResourcePack(string $resourcePackName): array|bool
    {
        $resourcePack = self::$configurations["resource_pack"][$resourcePackName] ?? null;
        if (empty($resourcePack)) return false;
        $srcContainer = [];
        $elementHandler = $resourcePack["htmlTag"];
        foreach ($resourcePack["resource"] as $resource) {
            $fullPath = self::$configurations["system_http_domain"] . $resource["directives"]["filePath"];
            $tagLink = "{$resource["directives"]["pathHandler"]}='{$fullPath}'";
            $attributes = [];
            foreach ($resource["elementAttributes"] as $attrName => $attrValue) {
                $attributes[] = "{$attrName}='{$attrValue}'";
            }
            $fullAttributes = implode(" ", $attributes);
            $fullTag = "<{$elementHandler} {$fullAttributes} $tagLink ></{$elementHandler}>\n";
            $srcContainer[] = $fullTag;
        }
        return $srcContainer ?? null;
    }
    public static function generateResourceLink() {}
}


Config::loadEnv();
$settings = [
    "database_host" => $_ENV["DB_HOST"],
    "database_name" => $_ENV["DB_NAME"],
    "database_password" => $_ENV["DB_PWD"],
    "database_username" => $_ENV["DB_USERNAME"],
    "system_developermode" => $_ENV["APP_DEVMODE"],
    "system_clientmode" => $_ENV["APP_CLIEMODE"],
    "system_strict_mode" => $_ENV["APP_STRICT_MODE"],
    "system_name" => $_ENV["APP_NAME"],
    "system_domain_name" => $_ENV["APP_DOMAIN_NAME"],
    "system_http_domain" => "http://" . $_ENV["APP_DOMAIN_NAME"],
    "system_https_domain" => "https://" . $_ENV["APP_DOMAIN_NAME"],
    "system_session_name" => $_ENV["APP_SESSION_NAME"],
    "system_session_cookie_lifetime" => $_ENV["APP_SESSION_LIFETIME"],
    "resource_pack" => [
        "CSSFiles" => [
            "htmlTag" => "link",
            "resource" => [
                [
                    "directives" => [
                        "filePath" => "/css/variables.css",
                        "pathHandler" => "href",
                    ],
                    "elementAttributes" => [
                        "rel" => "stylesheet",
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/css/login.page.css",
                        "pathHandler" => "href",
                    ],
                    "elementAttributes" => [
                        "rel" => "stylesheet",
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/css/signup.page.css",
                        "pathHandler" => "href",
                    ],
                    "elementAttributes" => [
                        "rel" => "stylesheet",
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/css/regular.user.dashb.css",
                        "pathHandler" => "href",
                    ],
                    "elementAttributes" => [
                        "rel" => "stylesheet",
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/css/regular.dashb.taskmanager.css",
                        "pathHandler" => "href",
                    ],
                    "elementAttributes" => [
                        "rel" => "stylesheet",
                    ]
                ],
            ],
        ],
        "JSFiles" => [
            "htmlTag" => "script",
            "resource" => [
                [
                    "directives" => [
                        "filePath" => "/js/dom.js",
                        "pathHandler" => "src",
                    ],
                    "elementAttributes" => [
                        "type" => "module",
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/js/metadata.js",
                        "pathHandler" => "src",
                    ],
                    "elementAttributes" => [
                        "type" => "module",
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/js/interactive.js",
                        "pathHandler" => "src",
                    ],
                    "elementAttributes" => [
                        "type" => "module",
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/js/_ftch.js",
                        "pathHandler" => "src",
                    ],
                    "elementAttributes" => [
                        "type" => "module",
                    ]
                ],
            ],
        ],
        "SVGIcons" => [
            "htmlTag" => "img",
            "resource" => [
                [
                    "directives" => [
                        "filePath" => "/svg/envelope.svg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Envelope icons",
                    ],
                ],
                [
                    "directives" => [
                        "filePath" => "/svg/eye-dark.svg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Password not visible",
                    ],
                ],
                [
                    "directives" => [
                        "filePath" => "/svg/eye-slash-dark.svg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Password invisible",
                    ],
                ],
                [
                    "directives" => [
                        "filePath" => "/svg/user.svg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Password invisible",
                    ],
                ],
                [
                    "directives" => [
                        "filePath" => "/svg/material_icons/add_person_dark.svg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Password invisible",
                    ],
                ],
                [
                    "directives" => [
                        "filePath" => "/svg/material_icons/manage_account_dark.svg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Password invisible",
                    ],
                ],
            ]
        ],
        "dummyImg" => [
            "htmlTag" => "img",
            "resource" => [
                [
                    "directives" => [
                        "filePath" => "/svg/gigchad.jpg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Dummy profile"
                    ]
                ],
                [
                    "directives" => [
                        "filePath" => "/svg/wojack_angry.jpg",
                        "pathHandler" => "src"
                    ],
                    "elementAttributes" => [
                        "style" => "width: 100%; height: 100%;",
                        "title" => "Password invisible",
                    ],
                ],
            ]
        ]
    ],
    "system_messages" => [
        "SERVER_SESSION_ERR" => [
            "No session available!",
        ],
        "SERVER_DB_ERR" => [
            "Table name does not exist in the database",
        ],
        "LOGIN_ERR" => [
            "You are already logged in!",
            "User does not exist in the database!",
            "Failed to set all data for current user!",
            "Failed to set log record for current user!"
        ],
        "LOGOUT_ERR" => [
            "You are already logged out!",
            "Something went wrong!",
            "Failed to logout account!",
        ],
        "ACCESS_GRANTED" => [
            "Succesfuly logged in!",
        ],
        "ACCESS_DENIED" => [
            "Incorrect email or password!",
            "Unsuccessfuly logged in!"
        ],
        "PASSWORD_ERR" => [
            "Password does not match!",
            "Password contains unusual characters!",
            "Password length must be between 8 - 20 characters!",
        ],
        "EMAIL_ERR" => [
            "Invalid email format",
        ],
        "SIGNUP_ERR" => [
            "User email already exist in the database!",
            "Failed to register new account!",
            "Failed to set log record for newly created account!",
        ],
        "SIGNUP_SUCCESS" => "You have successfuly registered an account!",
        "SERVER_ERR" => [
            "Incomplete data!"
        ]
    ]
];

Config::addFullSettings($settings);
