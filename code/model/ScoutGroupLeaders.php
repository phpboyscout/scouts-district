<?php
/**
 * ScoutGroupLeaders - code/model/ScoutGroupLeaders.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutGroupLeaders Model
 *
 * Class to provide model for Scout Group Leaders
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutGroupLeaders extends Page
{
    private static $allowed_children = array("none");

    private static $default_child = "Page";

    private static $default_parent = 'ScoutGroupSection';

    private static $can_be_root = false;

    private static $icon = null;

    private static $description = 'Page page to display Scout Groups Leaders Info';

    private static $db = array();

    private static $has_one = array();

    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $leadersGridConfig = GridFieldConfig_RelationEditor::create();
        $leadersGridConfig->addComponent(new GridFieldSortableRows('SortOrder'));

        $leadersGridField = new GridField(
            'Member',
            _t('ScoutGroup.LEADERS', 'Leaders'),
            $this->Leaders(),
            $leadersGridConfig
        );
        $fields->addFieldToTab('Root.Leaders', $leadersGridField);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function Leaders()
    {
        return $this->getParent()->Leaders();
    }
}