<?php
/**
 * ScoutSection - code/model/ScoutSection.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutSection Model
 *
 * Class to define model for individual Groups in a Scout District
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */

class ScoutSection extends Page
{
    private static $allowed_children = array("*Page");

    private static $default_child = "Page";

    private static $default_parent = 'Page';

    private static $can_be_root = false;

    private static $icon = null;

    private static $description = 'A Scout Section';

    private static $db = array(
        'Type' => 'Varchar',
        'Promise' => 'Text',
        'Law' => 'Text',
        'Motto' => 'Text',
//        'MembershipBadges' => 'HTMLText',
//        'ActivityBadges' => 'HTMLText',
//        'StagedBadges' => 'HTMLText',
//        'ChallengeBadges' => 'HTMLText',
//        'ChiefScout' => 'HTMLText',
    );

    private static $has_one = array(
        'Logo' => 'Image',
    );


    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $type = new DropdownField('Type', 'Type of Section', array(
            'beavers' => _t('ScoutDistrict.Enum.BEAVERS', 'Beavers'),
            'cubs' => _t('ScoutDistrict.Enum.CUBS', 'Cubs'),
            'scouts' => _t('ScoutDistrict.Enum.SCOUTS', 'Scouts'),
            'explorer' => _t('ScoutDistrict.Enum.EXPLORER', 'Explorer'),
            'network' => _t('ScoutDistrict.Enum.NETWORK', 'Network'),
        ));
        $fields->addFieldToTab('Root.Info', $type);


        $logo = new UploadField('Logo', _t('ScoutGroup.LOGO', 'Logo'));
        $logo->setFolderName('section/logo');
        $logo->setRightTitle(_t(
            'ScoutSection.LOGO_HELP',
            'The section logo'
        ))->addExtraClass('help');
        $fields->addFieldToTab('Root.Info', $logo);

        $fields->addFieldToTab('Root.Info', new TextareaField('Promise', _t('ScoutSection.PROMISE', 'Promise')));
        $fields->addFieldToTab('Root.Info', new TextareaField('Law', _t('ScoutSection.LAW', 'Law')));
        $fields->addFieldToTab('Root.Info', new TextareaField('Motto', _t('ScoutSection.MOTTO', 'Motto')));

//        $fields->addFieldToTab('Root.Info', new HtmlEditorField('MembershipBadges', _t('ScoutSection.MEMBERSHIPBADGES', 'Membership Badges')));
//        $fields->addFieldToTab('Root.Info', new HtmlEditorField('ActivityBadges', _t('ScoutSection.ACTIVITYBADGES', 'Activity Badges')));
//        $fields->addFieldToTab('Root.Info', new HtmlEditorField('StagedBadges', _t('ScoutSection.STAGEDBADGES', 'Staged Badges')));
//        $fields->addFieldToTab('Root.Info', new HtmlEditorField('ChallengeBadges', _t('ScoutSection.CHALLENGEBADGES', 'Challenge Badges')));
//        $fields->addFieldToTab('Root.Info', new HtmlEditorField('ChiefScout', _t('ScoutSection.CHIEFSCOUT', 'Chief Scout')));

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }


    protected $isInsert = false;

    public function onBeforeWrite()
    {
        if (!$this->ID) {
            $this->isInsert = true;
        }
       parent::onBeforeWrite();
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();

        if ($this->isInsert) {
            $blog = new BlogHolder();
            $blog->ParentID = $this->ID;
            $blog->Title = "News";
            $blog->ShowInMenus = false;
            $blog->write();
            $blog->publish('Stage', 'Live');

            $calendar = new Calendar();
            $calendar->ParentID = $this->ID;
            $calendar->Title = "Calendar";
            $calendar->ShowInMenus = false;
            $calendar->write();
            $calendar->publish('Stage', 'Live');

            $leaders = new ScoutGroupLeaders();
            $leaders->ParentID = $this->ID;
            $leaders->Title = "Leaders";
            $leaders->ShowInMenus = false;
            $leaders->write();
            $leaders->publish('Stage', 'Live');
        }
        $this->isInsert = false;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canAddChildren($member = null) {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canCreate($member = null) {
        $canDo = parent::canCreate($member);
        $canAdmin = Permission::check(ScoutDistrictPermissions::$district_admin);

        return ($canDo && $canAdmin);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canEdit($member = null) {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canDelete($member = null) {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canPublish($member = null) {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool|null
     */
    public function canDeleteFromLive($member = null) {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * Function to check if a member has the ability to perform
     * the appropriate can* action as well as manage groups
     *
     * @param $member
     * @param $method
     * @return bool
     */
    protected function checkCanManage($member, $method) {
        $canDo = parent::$method($member);
        $canAdmin = Permission::check(ScoutDistrictPermissions::$district_admin);
        $canManage = Permission::check(ScoutDistrictPermissions::$group_manager);

        return ($canDo && ($canAdmin || $canManage));
    }

    public function requireDefaultRecords()
    {
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

        if (!is_dir($root . '/assets/group/badge')) {
            if (mkdir($root . '/assets/group/badge', 0775, true)) {
                DB::alteration_message('Created Group Badge Folder', 'created');
            }
        }

        if (!is_dir($root . '/assets/group/necker')) {
            if (mkdir($root . '/assets/group/necker', 0775, true)) {
                DB::alteration_message('Created Group Necker Folder', 'created');
            }
        }
    }

}