<?php
/**
 * ScoutDistrictConfigExtension - code/extensions/ScoutDistrictConfigExtension.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutDistrictConfigExtension Extension
 *
 * Class to Extend SiteConfig for District Specific settings
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutDistrictConfigExtension extends DataExtension
{

    private static $db = array();

    private static $has_one = array(
        'DistrictLogo' => 'Image',
    );

    public function updateCMSFields(FieldList $fields)
    {
        $logo = new UploadField('DistrictLogo', _t('ScoutDistrict.Config.DISTRICTLOGO', 'District Logo'));
        $logo->setFolderName('logos');

        $fields->addFieldsToTab('Root.District', array(
            $logo,
        ));
    }
}
