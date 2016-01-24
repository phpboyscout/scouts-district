<?php
/**
 * Homepage - code/model/HomePage.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * HomePage Model
 *
 * Class to define model for Scout District specific website
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class HomePage extends Page
{
    private static $can_create = false;

    private static $description = 'Scout District Homepage';

    private static $singular_name = 'Homepage';

    private static $plural_name = 'Homepages';

    private static $db = array(
        'FirstTagLine' => 'Varchar(255)',
        'SecondTagLine' => 'Varchar(255)',
        'TagLinkText' => 'Varchar(255)',
        'TagLink' => 'Varchar(255)',
        'InfoPanelPage' => 'Varchar(255)',
        'BlogHolder' => 'Varchar(255)',
        'Calendar' => 'Varchar(255)',
    );

    private static $has_one = array(
        'BackgroundImage' => 'Image',
        'ForegroundImage' => 'Image',
        'FocalImageLeft' => 'Image',
        'FocalImageCentre' => 'Image',
        'FocalImageRight' => 'Image',
        'InfoPanelImage' => 'Image',
    );

    /**
     * Returns a FieldSet with which to create the CMS editing form.
     * You can use the extend() method of FieldSet to create customised forms for your other
     * data objects.
     *
     * @param Controller
     * @return FieldSet
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', 'Content');

        $BackgroundImageField = new UploadField('BackgroundImage');
        $BackgroundImageField->setFolderName('homepage');
        $fields->addFieldToTab('Root.Header', $BackgroundImageField);

        $ForegroundImageField = new UploadField('ForegroundImage');
        $ForegroundImageField->setFolderName('homepage');
        $fields->addFieldToTab('Root.Header', $ForegroundImageField);

        $FocalImageLeftField = new UploadField('FocalImageLeft');
        $FocalImageLeftField->setFolderName('homepage');
        $fields->addFieldToTab('Root.Header', $FocalImageLeftField);

        $FocalImageCentreField = new UploadField('FocalImageCentre');
        $FocalImageCentreField->setFolderName('homepage');
        $fields->addFieldToTab('Root.Header', $FocalImageCentreField);

        $FocalImageRightField = new UploadField('FocalImageRight');
        $FocalImageRightField->setFolderName('homepage');
        $fields->addFieldToTab('Root.Header', $FocalImageRightField);

        $fields->addFieldToTab(
            'Root.Header',
            new TextField(
                'FirstTagLine',
                _t('ScoutDistrict.Homepage.FirstTagLine', 'First Line of Header')
            )
        );

        $fields->addFieldToTab(
            'Root.Header',
            new TextField(
                'SecondTagLine',
                _t('ScoutDistrict.Homepage.SecondTagLine', 'Second Line of Header')
            )
        );

        $fields->addFieldToTab(
            'Root.Header',
            new TextField(
                'TagLinkText',
                _t('ScoutDistrict.Homepage.TagLinkText', 'Text to show on Header Button')
            )
        );

        $fields->addFieldToTab(
            'Root.Header',
            new TreeDropdownField(
                "TagLink",
                _t('ScoutDistrict.Homepage.TagLink', 'Where should Header Button link to'),
                "SiteTree"
            )
        );

        $blogDropdown = new TreeDropdownField(
            "BlogHolder",
            "Which blog/news page should we use",
            "SiteTree"
        );
        $fields->addFieldToTab('Root.Main', $blogDropdown, 'Metadata');

        $calDropdown = new TreeDropdownField(
            "Calendar",
            "Which calendar page should we use",
            "SiteTree"
        );
        $fields->addFieldToTab('Root.Main', $calDropdown, 'Metadata');

        $fields->addFieldToTab(
            'Root.Main',
            new TreeDropdownField(
                "InfoPanelPage",
                "Select the page to use in the Info panel",
                "SiteTree"
            ),
            'Metadata'
        );

        $infoImageField = new UploadField('InfoPanelImage');
        $fields->addFieldToTab('Root.Main', $infoImageField, 'Metadata');

        return $fields;
    }

    public function requireDefaultRecords()
    {
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        if (!is_dir($root . '/assets/homepage')) {
            mkdir($root . '/assets/homepage', 0775, true);
            DB::alteration_message('Created Homepage Assets Folder', 'created');
        }
    }
}
