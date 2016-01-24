<?php
/**
 * ScoutGroupSection - code/model/ScoutGroupSection.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutGroupSection Model
 *
 * Class to provide model for individual sections within a Scout Group
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutGroupSection extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'Type' => 'Varchar',
        'Info' => 'Text',
        'SortOrder' => 'Int',
    );

    private static $default_sort = 'SortOrder ASC';

    private static $has_one = array(
        'Group' => 'ScoutGroup',
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('SortOrder');

        $title = new TextField('Title', _t('ScoutGroup.Section.NAME', "Name of Section"));
        $fields->addFieldToTab('Root.Main', $title);

        $type = new DropdownField('Type', 'Type of Section', array(
            'beavers' => _t('ScoutDistrict.Enum.BEAVERS', 'Beavers'),
            'cubs' => _t('ScoutDistrict.Enum.CUBS', 'Cubs'),
            'scouts' => _t('ScoutDistrict.Enum.SCOUTS', 'Scouts'),
            'explorer' => _t('ScoutDistrict.Enum.EXPLORER', 'Explorer'),
            'network' => _t('ScoutDistrict.Enum.NETWORK', 'Network'),
        ));
        $fields->addFieldToTab('Root.Main', $type);

        $info = new TextareaField('Info', _t('ScoutGroup.Section.Info', "Info"));
        $info->setRightTitle(_t(
            'ScoutDistrict.Section.INFO_HELP',
            'Brief info about the section and meetings'
        ))->addExtraClass('help');
        $fields->addFieldToTab('Root.Main', $info);

        $fields->removeByName('GroupID');

        return $fields;
    }
}
