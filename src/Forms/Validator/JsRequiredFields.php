<?php
namespace LeKoala\Base\Forms\Validator;

use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;

/**
 * You also need to use
 *
 *     $this->setAttribute("data-module", "RequiredFields");
 *
 * on your form
 */
class JsRequiredFields extends RequiredFields
{
    public function __construct()
    {
        parent::__construct();

        Requirements::javascript("javascript/ModularBehaviour.js");
        Requirements::javascript("javascript/RequiredFields.js");
    }
}
