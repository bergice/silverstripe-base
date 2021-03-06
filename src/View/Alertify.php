<?php

namespace LeKoala\Base\View;

use SilverStripe\i18n\i18n;
use SilverStripe\Control\Cookie;
use SilverStripe\Control\Session;
use SilverStripe\View\Requirements;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Config\Configurable;

/**
 *
 * @link http://alertifyjs.com
 */
class Alertify
{
    use Configurable;

    /**
     * @config
     * @var string
     */
    private static $theme = 'bootstrap';

    /**
     * @config
     * @var array
     */
    private static $defaults = [
        'notifier.position' => "top-center",
        'transition' => "zoom",
        'theme.ok' => "btn btn-primary",
        'theme.cancel' => "btn btn-danger",
        'theme.input' => "form-control",
    ];

    /**
     * Add AlertifyJS requirements
     */
    public static function requirements()
    {
        $theme = self::config()->theme;

        Requirements::javascript('https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.11.1/alertify.min.js');
        $dir = i18n::get_script_direction();
        if ($dir == 'rtl') {
            Requirements::css('https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.11.1/css/alertify.rtl.min.css');
            Requirements::css('https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.11.1/css/themes/' . $theme . '.rtl.min.css');
        } else {
            Requirements::css('https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.11.1/css/alertify.min.css');
            Requirements::css('https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.11.1/css/themes/' . $theme . '.min.css');
        }
        $settings = '';
        foreach (self::config()->defaults as $k => $v) {
            $settings .= "alertify.defaults.$k = '$v';\n";
        }
        Requirements::customScript($settings, 'AlertifySettings');
    }

    /**
     * Display an alert only once (check is cookie based)
     *
     * @param string $name The name of the notification (name will be stored in a cookie)
     * @param string $message
     * @param string $type
     * @return bool Has the notification been displayed?
     */
    public static function notifyOnce($name, $message, $type)
    {
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();
        if ($session) {
            $check = $session->get($name);
        } else {
            $check = Cookie::get($name);
        }
        if ($check) {
            return false;
        }
        self::requirements();
        self::show($message, $type);
        if ($session) {
            $session->set($name, 1);
        } else {
            Cookie::set($name, 1);
        }
        return true;
    }

    public static function show($message, $type)
    {
        $msg = addslashes($message);
        $type = $type;
        switch ($type) {
            case 'good':
                $type = 'success';
                break;
            case 'bad':
                $type = 'error';
                break;
            case 'warn':
                $type = 'warning';
                break;
        }
        $js = "alertify.notify('$msg', '$type', 0);";
        Requirements::customScript($js);
    }

    /**
     * Display the flash message if any using Alertifyjs
     *
     * @param Session $session
     * @return void
     */
    public static function checkFlashMessage($session)
    {
        try {
            $FlashMessage = $session->get('FlashMessage');
        } catch (Exception $ex) {
            $FlashMessage = null; // Session can be null (eg : Security)
        }
        if (!$FlashMessage) {
            return;
        }
        $session->clear('FlashMessage');
        self::requirements();
        self::show($FlashMessage['Message'], $FlashMessage['Type']);
    }
}
