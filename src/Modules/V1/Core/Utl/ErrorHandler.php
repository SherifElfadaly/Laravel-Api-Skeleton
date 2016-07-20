<?php namespace App\Modules\V1\Core\Utl;

class ErrorHandler
{

    /**
     * Array of error messags.
     */
    private $messages = [
        "en" => [
            "unAuthorized"           => "Please login before any action",
            "tokenExpired"           => "Login token expired",
            "noPermissions"          => "No permissions",
            "loginFailed"            => "Wrong mail or password",
            "redisNotRunning"        => "Your redis notification server isn't running",
            "dbQueryError"           => "Please check the given inputes",
            "cannotCreateSetting"    => "Can't create setting",
            "cannotUpdateSettingKey" => "Can't update setting key",
            "userIsBlocked"          => "You have been blocked",
            "invalidResetToken"      => "Reset password token is invalid",
            "invalidResetPassword"   => "Reset password is invalid",
            "notFound"               => "The requested {replace} not found",
            "generalError"           => "Something went wrong",
        ],
        "ar" => [
            "unAuthorized"           => "من فضلك قم بتسجيل الدخول",
            "tokenExpired"           => "انتهت صلاحية الدخول",
            "noPermissions"          => "لا توجد صلاحية",
            "loginFailed"            => "خطأ في البريد لاكتروني او كلمة المرور",
            "redisNotRunning"        => "سيرفير الاشعارات لايعمل",
            "dbQueryError"           => "خطا في البيانات",
            "cannotCreateSetting"    => "لا يمكن اضافة اعدادات",
            "cannotUpdateSettingKey" => "لا يمكن تعديل اعدادات",
            "userIsBlocked"          => "لقد تم حظرك",
            "invalidResetToken"      => "رمز تعديل كلمة المرور خطا",
            "invalidResetPassword"   => "خطا في نعديل كلمة المرور",
            "notFound"               => "ال {replace} المطلوب غير موجود",
            "generalError"           => "حدث خطا ما",
        ]
    ];

    /**
     * The locale language.
     */
    private $locale;

    public function __construct()
    {
        $locale = \Session::get('locale');
        switch ($locale) 
        {
            case 'en':
            $this->locale = 'en';
            break;

            case 'ar':
            $this->locale = 'ar';
            break;

            case 'all':
            $this->locale = 'en';
            break;

            default:
            $this->locale = 'en';
            break;
        }
    }

    public function unAuthorized()
    {
        $error = ['status' => 401, 'message' => $this->messages[$this->locale]['unAuthorized']];
        abort($error['status'], $error['message']);
    }

    public function tokenExpired()
    {
        $error = ['status' => 403, 'message' => $this->messages[$this->locale]['tokenExpired']];
        abort($error['status'], $error['message']);
    }

     public function noPermissions()
    {
        $error = ['status' => 403, 'message' => $this->messages[$this->locale]['noPermissions']];
        abort($error['status'], $error['message']);
    }

    public function loginFailed()
    {
        $error = ['status' => 400, 'message' => $this->messages[$this->locale]['loginFailed']];
        abort($error['status'], $error['message']);
    }

    public function redisNotRunning()
    {
        $error = ['status' => 400, 'message' => $this->messages[$this->locale]['redisNotRunning']];
        abort($error['status'], $error['message']);
    }

    public function dbQueryError()
    {
        $error = ['status' => 400, 'message' => $this->messages[$this->locale]['dbQueryError']];
        abort($error['status'], $error['message']);
    }

    public function cannotCreateSetting()
    {
        $error = ['status' => 400, 'message' => $this->messages[$this->locale]['cannotCreateSetting']];
        abort($error['status'], $error['message']);
    }

    public function cannotUpdateSettingKey()
    {
        $error = ['status' => 400, 'message' => $this->messages[$this->locale]['cannotUpdateSettingKey']];
        abort($error['status'], $error['message']);
    }

    public function userIsBlocked()
    {
        $error = ['status' => 403, 'message' => $this->messages[$this->locale]['userIsBlocked']];
        abort($error['status'], $error['message']);
    }

    public function invalidResetToken()
    {
        $error = ['status' => 400, 'message' => $this->messages[$this->locale]['invalidResetToken']];
        abort($error['status'], $error['message']);
    }

    public function invalidResetPassword()
    {
        $error = ['status' => 400, 'message' => $this->messages[$this->locale]['invalidResetPassword']];
        abort($error['status'], $error['message']);
    }

    public function notFound($text)
    {
        $error = ['status' => 404, 'message' => str_replace($this->messages[$this->locale]['notFound'], '{replace}', $text)];
        abort($error['status'], $error['message']);
    }

    public function generalError()
    {
        $error = ['status' => 404, 'message' => $this->messages[$this->locale]['generalError']];
        abort($error['status'], $error['message']);
    }
}