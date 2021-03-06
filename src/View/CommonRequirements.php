<?php

namespace LeKoala\Base\View;

use SilverStripe\i18n\i18n;
use SilverStripe\Control\Director;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Config\Configurable;

/**
 * Configure shared requirements
 *
 * Easy to set custom versions in yml
 *
 * LeKoala\Base\View\CommonRequirements:
 *   jquery_version: '1.12.4'
 */
class CommonRequirements
{
    use Configurable;


    /**
     * @config
     * @var string
     */
    private static $jquery_version = '3.4.1';

    /**
     * @config
     * @var string
     */
    private static $accouting_version = '0.4.1';

    /**
     * @config
     * @var string
     */
    private static $moment_version = '2.23.0';

    /**
     * @config
     * @var string
     */
    private static $moment_timezone_version = '0.5.23';

    /**
     * @config
     * @var string
     */
    private static $datefns_version = '1.30.1';

    /**
     * @config
     * @var string
     */
    private static $fa4_version = '4.7.0';

    /**
     * @config
     * @var string
     */
    private static $fa5_version = '5.6.3';

    /**
     * @config
     * @var string
     */
    private static $boxicons_version = '2.0.2';

    /**
     * @config
     * @var string
     */
    private static $plyr_version = '3.4.5';

    /**
     * @config
     * @var string
     */
    private static $cleave_version = '1.4.10';

    /**
     * @config
     * @var string
     */
    private static $lazyload_ie_version = '8.17.0';

    /**
     * @config
     * @var string
     */
    private static $lazyload_version = '10.19.0';

    /**
     * @config
     * @var string
     */
    private static $fingerprintjs_version = '0.5.3';

    /**
     * @config
     * @var string
     */
    private static $counterup2_version = '1.0.4';

    /**
     * @config
     * @var string
     */
    private static $magnific_popup_version = '1.1.0';

    /**
     * @config
     * @var string
     */
    private static $owl_carousel2_version = '2.3.4';

    /**
     * @config
     * @var string
     */
    private static $aos_version = '2.3.4';

    /**
     * @config
     * @var string
     */
    private static $imagesLoaded_version = '4.1.4';

    /**
     * @config
     * @var string
     */
    private static $swiper_version = '4.5.0';

    /**
     * Include all files in a given path
     *
     * @param string $path
     * @return void
     */
    public static function includeInPath($path)
    {
        $js = glob($path . '/*.js');
        $base = Director::baseFolder();
        foreach ($js as $file) {
            $file = str_replace($base . '/', '', $file);
            Requirements::javascript($file);
        }
    }

    /**
     * Including modular behaviour tools to initialize scripts from html in one go
     *
     * Simply use  data-module="myModuleName" where myModuleName matches the jquery plugin
     * You can pass options in data-config="{"myOption": "true"}" (it has to be properly json encoded)
     *
     * Larger option array might be better in php data-config="$JsonOptionsHere"
     *
     * @return void
     */
    public static function modularBehaviour()
    {
        Requirements::javascript("javascript/ModularBehaviour.js");
    }

    /**
     * @link https://polyfill.io/v3/api/
     * @return void
     */
    public static function polyfillIo()
    {
        Requirements::javascript('https://cdn.polyfill.io/v3/polyfill.min.js?flags=gated');
    }

    /**
     * @param bool $slim
     * @return void
     */
    public static function jquery($slim = false)
    {
        $version = self::config()->jquery_version;
        $ext = '';
        if ($slim) {
            $ext = '.slim';
        }
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/jquery/$version/jquery" . $ext . ".min.js");
    }

    /**
     * @link https://github.com/sampotts/plyr
     * @param bool $css Include css, defaults to true
     * @param bool $polyfilled Use polyfilled version, defaults to false
     * @return void
     */
    public static function plyr($css = true, $polyfilled = false)
    {
        $version = self::config()->plyr_version;
        if ($css) {
            Requirements::css("https://cdn.plyr.io/$version/plyr.css");
        }
        if ($polyfilled) {
            Requirements::javascript("https://cdn.plyr.io/$version/plyr.polyfilled.js");
        } else {
            Requirements::javascript("https://cdn.plyr.io/$version/plyr.js");
        }
    }

    /**
     * @link https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js
     * @param string $lang
     * @param boolean $timezone
     * @return void
     */
    public static function moment($lang = null, $timezone = false)
    {
        if ($lang === null) {
            $lang = substr(i18n::get_locale(), 0, 2);
        }
        $version = self::config()->moment_version;
        $tzversion = self::config()->moment_timezone_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/moment.js/$version/moment-with-locales.min.js");
        if ($lang != 'en') {
            Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/moment.js/$version/locale/$lang.js");
        }
        if ($timezone) {
            Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/$tzversion/moment-timezone-with-data.min.js");
        }
    }

    /**
     * @link http://openexchangerates.github.io/accounting.js/
     * @return void
     */
    public static function accounting()
    {
        $version = self::config()->accouting_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/accounting.js/$version/accounting.min.js");
    }

    /**
     * @link https://date-fns.org/
     * @return void
     */
    public static function datefns()
    {
        $version = self::config()->datefns_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/date-fns/$version/date_fns.min.js");
    }

    /**
     * @link https://fontawesome.com/v4.7.0/cheatsheet/
     * @return void
     */
    public static function fontAwesome4()
    {
        $version = self::config()->fa4_version;
        Requirements::css("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/$version/css/font-awesome.min.css");
    }

    /**
     * @link https://fontawesome.com/cheatsheet
     * @return void
     */
    public static function fontAwesome5()
    {
        $version = self::config()->fa5_version;
        Requirements::css("https://use.fontawesome.com/releases/v${version}/css/all.css");
    }

    /**
     * @link https://boxicons.com/cheatsheet
     * @return void
     */
    public static function boxIcons()
    {
        $version = self::config()->boxicons_version;
        Requirements::css("https://cdn.jsdelivr.net/npm/boxicons@$version/css/boxicons.min.css");
    }

    /**
     * @link https://nosir.github.io/cleave.js/
     * @return void
     */
    public static function cleave()
    {
        $version = self::config()->cleave_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/cleave.js/$version/cleave.min.js");
    }

    /**
     * @link https://github.com/valve/fingerprintjs/
     * @return void
     */
    public static function fingerprintjs()
    {
        $version = self::config()->fingerprintjs_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/fingerprintjs/$version/fingerprint.min.js");
    }

    /**
     * @return void
     */
    public static function utils()
    {
        Requirements::javascript("javascript/utils.js");
    }

    /**
     * With added custom event polyfill
     * @link https://github.com/thepinecode/canvi
     * @return void
     */
    public static function canvi()
    {
        Requirements::css("javascript/vendor/canvi/canvi.css");
        Requirements::javascript("javascript/vendor/canvi/canvi.min.js");
    }

    /**
     * @link https://github.com/verlok/lazyload
     * @return void
     */
    public static function lazyload()
    {
        $version = self::config()->lazyload_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/$version/lazyload.min.js");
        // Requirements::javascript("https://cdn.jsdelivr.net/npm/vanilla-lazyload@$version/dist/lazyload.min.js");
    }

    /**
     * @link https://github.com/verlok/lazyload
     * @return void
     */
    public static function lazyload_ie()
    {
        $version = self::config()->lazyload_ie_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/$version/lazyload.min.js");
        // Requirements::javascript("https://cdn.jsdelivr.net/npm/vanilla-lazyload@$version/dist/lazyload.min.js");
    }

    /**
     * @link https://github.com/verlok/lazyload
     * @return void
     */
    public static function lazyload_auto()
    {
        $version = self::config()->lazyload_version;
        $ie_version = self::config()->lazyload_ie_version;

        $js = <<<JS
(function(w, d){
    var b = d.getElementsByTagName('body')[0];
    var s = d.createElement("script");
    var v = !("IntersectionObserver" in w) ? "$ie_version" : "$version";
    s.async = true;
    s.src = "https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/" + v + "/lazyload.min.js";
    w.lazyLoadOptions = {
        elements_selector: ".lazy"
    };
    b.appendChild(s);
}(window, document));
JS;
        Requirements::customScript($js, 'LazyloadAuto');
    }

    /**
     * @link https://github.com/bfintal/Counter-Up2
     * @return void
     */
    public static function counterup2()
    {
        $version = self::config()->counterup2_version;
        Requirements::javascript("https://cdn.jsdelivr.net/npm/counterup2@$version/dist/index.min.js");
    }

    /**
     * @link https://dimsemenov.com/plugins/magnific-popup/
     * @param bool $css
     * @return void
     */
    public static function magnificPopup($css = true)
    {
        $version = self::config()->magnific_popup_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/$version/jquery.magnific-popup.min.js");
        if ($css) {
            Requirements::css("https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/$version/magnific-popup.min.css");
        }
    }

    /**
     * If you use ModularBehaviour, you can just do data-module="owlCarousel"
     *
     * @link https://github.com/OwlCarousel2/OwlCarousel2
     * @param bool $css If you set this to false, think about including ../../../base/sass/vendor/owl-carousel2/owl.carousel
     * @param bool $theme Name of your theme, stored in ../../../base/sass/vendor/owl-carousel2/owl.theme.default if you build your own styles
     * @return void
     */
    public static function owlCarousel2($css = true, $theme = 'default')
    {
        $version = self::config()->owl_carousel2_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/$version/owl.carousel.min.js");
        if ($css) {
            Requirements::css("https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/$version/assets/owl.carousel.min.css");
        }
        if ($css && $theme) {
            Requirements::css("https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/$version/assets/owl.theme.$theme.min.css");
        }
    }

    /**
     * @link https://michalsnik.github.io/aos/
     * @param bool $css
     * @return void
     */
    public static function aos($css = true)
    {
        $version = self::config()->aos_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/aos/$version/aos.js");
        if ($css) {
            Requirements::css("https://cdnjs.cloudflare.com/ajax/libs/aos/$version/aos.css");
        }
    }

    /**
     * @link https://imagesloaded.desandro.com/
     * @return void
     */
    public static function imagesLoaded()
    {
        $version = self::config()->imagesLoaded_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/$version/imagesloaded.min.js");
    }

    /**
     * @link http://idangero.us/swiper
     * @param bool $css
     * @return void
     */
    public static function swiper($css = true)
    {
        $version = self::config()->swiper_version;
        Requirements::javascript("https://cdnjs.cloudflare.com/ajax/libs/Swiper/$version/js/swiper.min.js");
        if ($css) {
            Requirements::css("https://cdnjs.cloudflare.com/ajax/libs/Swiper/$version/css/swiper.min.css");
        }
    }
}
