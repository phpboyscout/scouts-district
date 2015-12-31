<?php
/**
 * ScoutGroupHolder - code/model/ScoutGroupHolder.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutGroupHolder Model
 *
 * Class to provide container for Scout Groups
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutGroupHolder extends Page implements PermissionProvider
{
    private static $allowed_children = array("ScoutGroup" , "RedirectorPage");

    private static $default_child = "ScoutGroup";

    private static $icon = null;

    private static $description = 'A holder for Scout Groups';

    private static $db = array(
    );

    private static $has_one = array(
    );

    /**
     * @param null $member
     * @return bool
     */
    public function canAddChildren($member = null)
    {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canCreate($member = null)
    {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canEdit($member = null)
    {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canDelete($member = null)
    {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canPublish($member = null)
    {
        return $this->checkCanManage($member, __FUNCTION__);
    }

    /**
     * @param null $member
     * @return bool|null
     */
    public function canDeleteFromLive($member = null)
    {
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
    protected function checkCanManage($member, $method)
    {
        $canDo = parent::$method($member);
        $canManage = Permission::check(ScoutDistrictPermissions::$district_admin);

        return ($canDo && $canManage);
    }


    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        if ($this->config()->create_default_pages) {
            $groupHolder = DataObject::get_one('ScoutGroupHolder');
            if (!$groupHolder) {
                $groupHolder = new ScoutGroupHolder();
                $groupHolder->Title = "Groups";
                $groupHolder->URLSegment = 'groups';
                $groupHolder->Status = 'Published';
                $groupHolder->write();
                $groupHolder->publish('Stage', 'Live');
                DB::alteration_message('Scout Group Holder page created', 'created');
            }
        }

        $districtAdmin = DataObject::get_one('Group', "Code = 'scout-district-admin'");
        if (!$districtAdmin) {
            $districtAdmin = new Group();
            $districtAdmin->Code = 'scout-district-admin';
            $districtAdmin->Title = _t('ScoutDistrict.Groups.SCOUTDISTRICTADMIN', 'Scout District Admin');
            $districtAdmin->write();
            Permission::grant($districtAdmin->ID, ScoutDistrictPermissions::$district_admin);
            DB::alteration_message('Scout District Admin group created', 'created');
        }
        $groupManager = DataObject::get_one('Group', "Code = 'scout-group-manager'");
        if (!$groupManager) {
            $groupManager = new Group();
            $groupManager->Code = 'scout-group-manager';
            $groupManager->Title = _t('ScoutDistrict.Groups.SCOUTGROUPMANAGER', 'Scout Group Manager');
            $groupManager->write();
            Permission::grant($groupManager->ID, ScoutDistrictPermissions::$group_manager);
            Permission::grant($groupManager->ID, "CMS_ACCESS_CMSMain");
            DB::alteration_message('Scout Group Manager group created', 'created');
        }
    }
}
