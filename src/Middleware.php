<?php

declare(strict_types=1);

use Ramsey\Uuid\Uuid;

class Middleware
{
    private $configurations;
    private $builtInSystemCMsgs;
    private $databaseModel;
    private $messages = [];

    public function __construct()
    {
        $this->configurations = Config::getAllSettings();
        $this->builtInSystemCMsgs = Config::getBuiltInSystemMsgs();
        $this->databaseModel = DatabaseModel::getInstance();
    }

    # SESSIONS, COOKIES, AND DEPENDENCIES
    public function prepareDependencies(): void
    {
        self::$configurations = Config::getAllSettings();
    }

    public function initiateSessionCookies(): void
    {
        session_set_cookie_params([
            "lifetime" => 500,
            "path" => "/",
            "domain" => $this->configurations["system_domain_name"],
            "secure" => false,
            "httponly" => true,
            "samesite" => "Lax",
        ]);
    }

    public function startSession(): void
    {
        session_name($this->configurations["system_session_name"]);
        session_start();
    }

    public function getSessionData(
        string $sessionKey,
    ): mixed {
        return $_SESSION[$sessionKey] ?? null;
    }

    public function setSessionData(
        string $sessionKey,
        mixed $sessionData,
    ): bool {
        $_SESSION[$sessionKey] = $sessionData;
        return true;
    }

    public function destroySessions(): void
    {
        session_destroy();
    }

    public function unsetSessions(): void
    {
        session_unset();
    }

    public function setRegenerateSessionId(): void
    {
        session_regenerate_id(true);
    }

    public function isSessionAvailable(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    # USER VALIDATOR
    public function isUserAlreadyLoggedIn(): mixed
    {
        return !empty($_SESSION["userAccount"]);
    }

    public static function isMatchedPassword(
        string $password,
        string $hashedPassword,
    ): bool {
        return password_verify(
            $password,
            $hashedPassword
        );
    }

    public function isValidEmailFormat(
        $email,
    ): bool {
        if (!filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )) return false;
        $domain = substr(
            strrchr(
                $email,
                "@"
            ),
            1
        );
        if (strtolower($domain) !== 'gmail.com') return false;
        return true;
    }

    public function isAnyColumnEmpty(
        array $data,
        bool $sendMsg = false,
    ) {
        $isEmpty = true;
        foreach ($data as $key => $data) {
            if (empty($data)) {
                $isEmpty = true;
                break;
            }
            $isEmpty = false;
        }
        if ($sendMsg && $isEmpty) {
            die(json_encode([
                "message" => "Incomplete data.",
                "type" => "INCOMPLETE_DATA",
                "status" => "unsuccessful",
            ]));
        } else {
            return $isEmpty;
        }
    }

    public function validateCSRFToken(
        string $token,
        bool $sendMsg = false,
    ) {
        /*
        if ($sendMsg && $token !== $_SESSION["csrf_token"]) {
            die(json_encode([
                "message" => "Incomplete data.",
                "type" => "INCOMPLETE_DATA",
                "status" => "unsuccessful",
            ]));
        } else {
            return false;
        }
        return true;
        */
        if ($sendMsg && $token !== "123" || empty($token)) {
            die(json_encode([
                "message" => "Invalid or Empty token.",
                "type" => "TOKEN_ERR",
                "status" => "unsuccessful",
            ]));
        } else {
            return false;
        }
        return true;
    }

    # GETTERS
    public function getUUID(): string
    {
        $uuid = Uuid::uuid4();
        return $uuid->toString();
    }

    public function getModifiedTime(
        string $currentTime,
    ): string | null {
        $timeZone = new DateTimeZone("Asia/Taipei");
        $time = new DateTime($currentTime, $timeZone);
        $timeFormat = $time->format("F j, Y");
        return $timeFormat ?? null;
    }

    public function getCurrentTime($timeZone = "Asia/Taipei"): string
    {
        $dTimeZone = new DateTimeZone($timeZone);
        $taskCompleted = new DateTime("now", $dTimeZone);
        $now = $taskCompleted->format("Y-m-d h-i-s");
        return $now;
    }

    public function getPasswordHashing(
        string $password,
    ): string | null {
        return password_hash(
            $password,
            PASSWORD_BCRYPT
        ) ?? null;
    }

    public function getMsg(
        string $errKey,
    ): array | null {
        return $this->builtInSystemCMsgs[$errKey] ?? null;
    }

    public function getTimeDiff(
        string $previous
    ): array {
        $dateTimeZone = new DateTimeZone("Asia/Taipei");
        $pastDate = new DateTime(
            $previous,
            $dateTimeZone
        );
        $currentDate = new DateTime();
        $gap = $currentDate->diff($pastDate);
        $timeFormatArray = [];
        $year = $gap->y;
        $month = $gap->m;
        $day = $gap->d;
        $hour = $gap->h;
        $minute = $gap->i;
        $second = $gap->s;
        if (!empty($year)) $year > 1 ?
            $timeFormatArray["yr"] = "{$year} years"
            : $timeFormatArray["yr"] = "{$year} year";
        if (!empty($month)) $month > 1 ?
            $timeFormatArray["mo"] = "{$month} months"
            : $timeFormatArray["mo"] = "{$month} month";
        if (!empty($month)) $day > 1 ?
            $timeFormatArray["da"] = "{$day} days"
            : $timeFormatArray["da"] = "{$year} day";
        if (!empty($hour)) $hour > 1 ?
            $timeFormatArray["hr"] = "{$hour} hours"
            : $timeFormatArray["hr"] = "{$hour} hour";
        if (!empty($minute)) $minute > 1 ?
            $timeFormatArray["min"] = "{$minute} minutes"
            : $timeFormatArray["min"] = "{$minute} minute";
        if (!empty($second)) $second > 1
            ? $timeFormatArray["sec"] = "{$second} seconds"
            : $timeFormatArray["sec"] = "{$second} second";
        return $timeFormatArray;
    }

    # SANITIZERS
    public static function stringSanitization(
        string $input
    ): string {
        $sanitized = strip_tags($input);
        $sanitized = htmlspecialchars(
            $sanitized,
            ENT_QUOTES,
            'UTF-8'
        );
        $sanitized = trim($sanitized);
        return $sanitized;
    }

    public function sanitizePassword(
        string $password,
        int $minLength = 8,
        int $maxLength = 20,
    ): string {
        $allowedChars = '/^[a-zA-Z0-9!@#$%^&*()_+\-= \[\] {};:\'\\|,.<>\/?]*$/';
        if (!preg_match(
            $allowedChars,
            $password,
        )) {
            $this->messages[$this->getMsg("PASSWORD_ERR")["messageName"]] =
                $this->getMsg("PASSWORD_ERR", 1)["message"][1];
            die(json_encode($this->messages));
        }
        $passwordLength = strlen($password);
        if (
            $passwordLength < $minLength ||
            $passwordLength > $maxLength
        ) {
            $this->messages[$this->getMsg("PASSWORD_ERR")["messageName"]] =
                $this->getMsg("PASSWORD_ERR", 2)["message"][2];
            die(json_encode($this->messages));
        }
        return $password;
    }

    public function setCSRFToken(): void
    {
        $token = hash("sha512", random_bytes(64));
        $this->setSessionData("csrf_t", $token);
    }

    public function generateRandomToken(): string
    {
        # TODO
        return bin2hex(random_bytes(8));
    }

    public function spillJSON(): array
    {
        return json_decode(file_get_contents("php://input"), true);
    }
};
