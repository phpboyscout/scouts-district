<?php
/**
 * ScoutSection_Controller - code/extensions/ScoutGroup_Controller.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutSection Controller
 *
 * Controller to display ScoutSection
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutSection_Controller extends Page_Controller
{
    public function Groups()
    {
        $data = DataObject::get(
            "ScoutGroup",
            "ScoutGroupSection.Type = '" . $this->dataRecord->Type . "'"
        )->leftJoin("ScoutGroupSection", "`ScoutGroup`.`ID` = `ScoutGroupSection`.`GroupID`");

        return $data;
    }

    public function SectionLabel()
    {
        switch ($this->dataRecord->Type) {
            case 'beavers':
                $label = 'Beaver Colonies';
                break;
            case 'cubs':
                $label = 'Cub Packs';
                break;
            case 'scouts':
                $label = 'Scout Troops';
                break;
            case 'explorers':
                $label = 'Explorer Units';
                break;
            default:
                $label = 'Sections';
                break;
        }
        return $label;
    }
}
