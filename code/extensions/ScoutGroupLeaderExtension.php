<?php
/**
 * ScoutGroupLeaderExtension - code/extensions/ScoutGroupLeaderExtension.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutGroupLeaderExtension Extension
 *
 * Class to Extend Members object to provide Scout specific settings
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutGroupLeaderExtension extends DataExtension
{

    private static $db = array(
        'Nickname' => 'varchar',
        'SortOrder' => 'Int',
        'Biography' => 'HTMLText',

    );

    public static $default_sort='SortOrder';

    private static $has_one = array(
        'Avatar' => 'Image',
        'ScoutRole' => 'ScoutRole',
    );

    private static $many_many = array(
        'ScoutGroups' => 'ScoutGroup',
    );

    public function updateCMSFields(FieldList $fields)
    {
        $avatar = new UploadField('Avatar', 'Avatar');
        $avatar->setFolderName('member/avatar');
        $fields->replaceField('Avatar', $avatar);
        $fields->removeByName('SortOrder');
    }

    public function requireDefaultRecords()
    {
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        if (!is_dir($root . '/assets/member/avatar')) {
            mkdir($root . '/assets/member/avatar', 0775, true);
            DB::alteration_message('Created Members Avatar Folder', 'created');
        }
    }
}
