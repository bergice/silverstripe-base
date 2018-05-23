<?php

namespace LeKoala\Base\Admin;

use SilverStripe\Forms\Form;
use SilverStripe\ORM\DataObject;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;

abstract class BaseModelAdmin extends ModelAdmin
{

    /**
     * @return int
     */
    public function getSubsiteId()
    {
        return \SilverStripe\Subsites\State\SubsiteState::singleton()->getSubsiteId();
    }

    public function getList()
    {
        $list = parent::getList();
        $singl = singleton($this->modelClass);
        $config = $singl->config();

        // Sort by custom sort order
        if ($config->model_admin_sort) {
            $list = $list->sort($config->model_admin_sort);
        }

        return $list;
    }

    /**
     * @return string
     */
    protected function getSanitisedModelClass()
    {
        return $this->sanitiseClassName($this->modelClass);
    }

    /**
     * Get gridfield for current model
     * Makes it easy for your ide
     *
     * @param Form $form
     * @return GridField
     */
    public function getGridField(Form $form)
    {
        return $form->Fields()->dataFieldByName($this->getSanitisedModelClass());
    }

    /**
     * @param DataObject $record
     * @return string
     */
    public static function getEditLink(DataObject $record)
    {
        $URLSegment = static::config()->url_segment;
        $recordClass = get_class($record);
        $ID = $record->ID;
        return "/admin/URLSegment/$recordClass/EditForm/field/recordClass/item/$ID/edit";
    }
}
