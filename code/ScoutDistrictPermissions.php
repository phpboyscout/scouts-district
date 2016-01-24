<?php
/**
 * ScoutDistrictPermissions - code/extensions/ScoutDistrictPermissions.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutDistrictPermissions
 *
 * Class  provide permission definitions for Scout Districts
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutDistrictPermissions implements PermissionProvider
{
    public static $district_admin =  'SCOUTDISTRICTADMIN';

    public static $group_manager =  'SCOUTGROUPMANAGER';

    public function providePermissions()
    {
        return array(
            self::$district_admin => array(
                'name' => _t('ScoutDistrict.Admin.DISTRICTADMIN', 'Scout Group Manager'),
                'help' => _t('ScoutDistrict.Admin.DISTRICTADMIN_HELP',  'Enable ability to manage Scout Groups'),
                'category' => _t('ScoutDistrict.Admin.PERMISSIONS_CATEGORY', 'Scout District'),
                'sort' => 100
            ),
            self::$group_manager => array(
                'name' => _t('ScoutDistrict.Admin.GROUPMANAGER', 'Scout Group Manager'),
                'help' => _t('ScoutDistrict.Admin.GROUPMANAGEMER_HELP',  'Enable ability to manage Scout Groups'),
                'category' => _t('ScoutDistrict.Admin.PERMISSIONS_CATEGORY', 'Scout District'),
                'sort' => 100
            )
        );
    }
}
