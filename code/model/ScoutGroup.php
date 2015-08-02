<?php
/**
 * ScoutGroup - code/model/ScoutGroup.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutGroup Model
 *
 * Class to define model for individual Groups in a Scout District
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */

class ScoutGroup extends Page
{
    private static $allowed_children = array("*Page","UserDefinedForm", "Calendar","BlogHolder","ScoutGroupLeaders");

    private static $default_child = "Page";

    private static $default_parent = 'ScoutGroupHolder';

    private static $can_be_root = false;

    private static $icon = null;

    private static $description = 'Page for a Scout Groups';

    private static $db = array(
        'TwitterUser' => 'varchar(255)',
        'FacebookPage' => 'varchar(255)',
        'GooglePage' => 'varchar(255)',
        'Address1' => 'varchar',
        'Address2' => 'varchar',
        'Address3' => 'varchar',
        'Town' => 'varchar',
        'Postcode' => 'varchar',
        'Phone' => 'varchar',
        'Email' => 'varchar',
        'CharityNumber' => 'varchar',
        'NeckerDescription' => 'varchar',
    );

    private static $has_one = array(
        'Badge' => 'Image',
        'Necker' => 'Image',
    );

    private static $has_many = array(
        'Sections' => 'ScoutGroupSection',
    );

    private static $many_many = array(
        'Leaders' => 'Member',
    );

    private static $many_many_extraFields = array(
        'Leaders' => array('Section' => 'Int')
    );

    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $badge = new UploadField('Badge', _t('ScoutGroup.BADGE', 'Badge'));
        $badge->setFolderName('group/badge');
        $badge->setRightTitle(_t(
            'ScoutGroup.BADGE_HELP',
            'The badge/logo/emblem of the Group'
        ))->addExtraClass('help');
        $fields->addFieldToTab('Root.Info', $badge);

        $necker = new UploadField('Necker', _t('ScoutGroup.NECKER', 'Necker'));
        $necker->setFolderName('group/necker');
        $necker->setRightTitle(_t(
            'ScoutGroup.NECKER_HELP',
            'The neckerchief the Group'
        ))->addExtraClass('help');
        $fields->addFieldToTab('Root.Info', $necker);

        $fields->addFieldToTab('Root.Info', new TextField('NeckerDescription', _t('ScoutGroup.NECKERDESCRIPTION', 'Neckerchief Description')));

        $fields->addFieldToTab('Root.Social', new TextField('TwitterUser', _t('ScoutGroup.TWITTERUSER', 'Twitter User')));
        $fields->addFieldToTab('Root.Social', new TextField('FacebookPage', _t('ScoutGroup.FACEBOOKPAGE', 'Facebook Page')));
        $fields->addFieldToTab('Root.Social', new TextField('GooglePage', _t('ScoutGroup.GOOGLEPAGE', 'Google Page')));

        $fields->addFieldToTab('Root.Contact', new TextField('Address1', _t('ScoutGroup.ADDRESS1', 'Address 1')));
        $fields->addFieldToTab('Root.Contact', new TextField('Address2', _t('ScoutGroup.ADDRESS2', 'Address 2')));
        $fields->addFieldToTab('Root.Contact', new TextField('Address3', _t('ScoutGroup.ADDRESS3', 'Address 3')));
        $fields->addFieldToTab('Root.Contact', new TextField('Town', _t('ScoutGroup.TOWN', 'Town')));
        $fields->addFieldToTab('Root.Contact', new TextField('Postcode', _t('ScoutGroup.POSTCODE', 'Post Code')));
        $fields->addFieldToTab('Root.Contact', new TextField('Phone', _t('ScoutGroup.PHONE', 'Phone #')));
        $fields->addFieldToTab('Root.Contact', new TextField('Email', _t('ScoutGroup.EMAIL', 'Email Address')));
        $fields->addFieldToTab('Root.Contact', new TextField('CharityNumber', _t('ScoutGroup.CHARITYNUMBER', 'CharityNumber')));

        $sectionGridConfig = new GridFieldConfig_RecordEditor();
        $sectionGridConfig->addComponent(new GridFieldSortableRows('SortOrder'));
        $sectionGrid = new GridField('Sections', 'Sections', $this->Sections(), $sectionGridConfig);

        $fields->addFieldToTab('Root.Sections', $sectionGrid);

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