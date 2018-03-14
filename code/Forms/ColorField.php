<?php
namespace LeKoala\Base\Forms;

use SilverStripe\i18n\i18n;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

/**
 * @link https://bgrins.github.io/spectrum/
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color
 */
class ColorField extends TextField
{
    /**
     * Override locale. If empty will default to current locale
     *
     * @var string
     */
    protected $locale = null;

    /**
     * Config array
     *
     * @var array
     */
    protected $config = [];

    private static $default_config = [];

    public function __construct($name, $title = null, $value = '', $maxLength = null, $form = null)
    {
        parent::__construct($name, $title, $value, $maxLength, $form);

        $this->config = self::config()->default_config;
    }

    public function getInputType()
    {
        return 'color';
    }

    public function Type()
    {
        return 'spectrum';
    }

    public function getConfig($key)
    {
        if (isset($this->config)) {
            return $this->config[$key];
        }
    }

    public function setConfig($key, $value)
    {
        if ($value) {
            $this->config[$key] = $value;
        } else {
            unset($this->config[$key]);
        }
        return $this;
    }

    public function getList()
    {
        return $this->getConfig('list');
    }

    public function setList($values)
    {
        $this->setConfig('list', $values);
    }


    /**
     * Get locale to use for this field
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale ? : i18n::get_locale();
    }

    /**
     * Determines the presented/processed format based on locale defaults,
     * instead of explicitly setting {@link setDateFormat()}.
     * Only applicable with {@link setHTML5(false)}.
     *
     * @param string $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    public function Field($properties = array())
    {
         // Set lang based on locale
        $lang = substr($this->getLocale(), 0, 2);

        $config = $this->config;

        $this->setAttribute('data-config', json_encode($config));

        Requirements::css('https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css');
        Requirements::javascript('https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js');
        if ($lang != 'en') {
        }
        Requirements::javascript('base/javascript/ColorField.js');

        return parent::Field($properties);
    }
}
