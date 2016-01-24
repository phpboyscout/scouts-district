<?php
/**
 * ScoutRole - code/model/ScoutRole.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutRole Model
 *
 * Class to provide model the different Roles in Scouting
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutRole extends DataObject
{
    private static $db = array(
        'Title' => 'varchar',
        'Acronym' => 'varchar',
    );

    private static $has_one = array();

    private static $has_many = array(
        'Members' => 'Member'
    );

    private $roles = array(
        array('Title' => 'Group Scout Leader', 'Acronym' => 'GSL'),
        array('Title' => 'Beaver Scout Leader', 'Acronym' => 'BSL'),
        array('Title' => 'Assistant Beaver Scout Leader', 'Acronym' => 'ABSL'),
        array('Title' => 'Cub Scout Leader', 'Acronym' => 'CSL'),
        array('Title' => 'Assistant Cub Scout Leader', 'Acronym' => 'ACSL'),
        array('Title' => 'Scout Leader', 'Acronym' => 'SL'),
        array('Title' => 'Assistant Scout Leader', 'Acronym' => 'ASL'),
        array('Title' => 'Explorer Scout Leader', 'Acronym' => 'ESL'),
        array('Title' => 'Assistant Explorer Scout Leader', 'Acronym' => 'AESL'),
        array('Title' => 'Section Assistant', 'Acronym' => 'SA'),
        array('Title' => 'Occasional Helper', 'Acronym' => 'OH'),
        array('Title' => 'Group Chairman', 'Acronym' => 'Chair'),
        array('Title' => 'Group Treasurer', 'Acronym' => 'Treasurer'),
        array('Title' => 'Group Secretary', 'Acronym' => 'Secretary'),
    );

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();
        foreach ($this->roles as $role) {
            $ScoutRole = DataObject::get_one('ScoutRole', "Title = '" . $role['Title'] . "'");
            if (!$ScoutRole) {
                $ScoutRole = new ScoutRole();
                $ScoutRole->Title = $role['Title'];
                $ScoutRole->Acronym = $role['Acronym'];
                $ScoutRole->write();
                DB::alteration_message($ScoutRole->Title . ' (' . $ScoutRole->Acronym . ') Scout Role created', 'created');
            }
        }
    }
}
