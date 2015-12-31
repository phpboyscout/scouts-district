<?php
/**
 * ScoutCalenderEventExtension - code/extensions/ScoutCalenderEventExtension.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutCalenderEventExtension Extension
 *
 * Class to Extend silverstripe-eventcalendar Events
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutCalenderEventExtension extends DataExtension
{

    private static $db = array(
        'EventType' => 'Varchar(255)',
        'EventSection' => 'Int',
        'EventLocation' => 'Text',
        'EventLatitude' => 'Varchar(15)',
        'EventLongitude' => 'Varchar(15)',
        'EventBookingDetails' => 'HTMLText',
        'EventBookingURL' => 'Varchar(255)',
    );

    private static $has_one = array(
        'ThumbnailImage' => 'Image',
        'Image' => 'Image',
    );

    private static $has_many = array(
        'Files' => 'ScoutEventFile',
    );

    public function updateCMSFields(FieldList $fields)
    {
        $type = new DropdownField('EventType', _t('ScoutDistrict.Events.TYPE', 'Type'), array(
            'section-meeting' => _t('ScoutDistrict.Enum.SECTIONMEETING', 'Section Meeting'),
            'leaders-meeting' => _t('ScoutDistrict.Enum.LEADERSMEETING', 'Leaders Meeting'),
            'activity' => _t('ScoutDistrict.Enum.ACTIVITY', 'Activity'),
            'fundraising' => _t('ScoutDistrict.Enum.FUNDRAISING', 'Fundraising'),
            'committee' => _t('ScoutDistrict.Enum.COMMITTEE', 'Committee'),
            'camp' => _t('ScoutDistrict.Enum.CAMP', 'Camp'),
            'group' => _t('ScoutDistrict.Enum.GROUP', 'Group'),
            'district' => _t('ScoutDistrict.Enum.DISTRICT', 'District'),
            'training' => _t('ScoutDistrict.Enum.TRAINING', 'Training'),
            'other' => _t('ScoutDistrict.Enum.OTHER', 'Other'),
        ));
        $type->setRightTitle(_t(
            'ScoutDistrict.Events.TYPE_HELP',
            'What Type of event is this'
        ))->addExtraClass('help');

        $location = new TextField('EventLocation', _t('ScoutDistrict.Events.LOCATION', 'Location'));
        $location->setRightTitle(_t(
            'ScoutDistrict.Events.LOCATION_HELP',
            'Where is the event being held'
        ))->addExtraClass('help');

        $latitude = new TextField('EventLatitude', _t('ScoutDistrict.Events.LATITUDE', 'Latitude'));
        $latitude->setRightTitle(_t(
            'ScoutDistrict.Events.LATITUDE_HELP',
            'Latitude of event Location'
        ))->addExtraClass('help');

        $longitude = new TextField('EventLongitude', _t('ScoutDistrict.Events.LONGITUDE', 'Longitude'));
        $longitude->setRightTitle(_t(
            'ScoutDistrict.Events.LONGITUDE_HELP',
            'Longitude of event Location'
        ))->addExtraClass('help');

        $bookingDetails = new TextareaField('EventBookingDetails', _t('ScoutDistrict.Events.BOOKINGDETAILS', 'Booking Details'));
        $bookingDetails->setRightTitle(_t(
            'ScoutDistrict.Events.BOOKINGDETAILS_HELP',
            'Details of how to book a place for the Event'
        ))->addExtraClass('help');

        $bookingURL = new TextField('EventBookingURL', _t('ScoutDistrict.Events.BOOKINGURL', 'Booking URL'));
        $bookingURL->setRightTitle(_t(
            'ScoutDistrict.Events.BOOKINGURL_HELP',
            'The URL of an external site to book a place'
        ))->addExtraClass('help');

        $fields->addFieldsToTab('Root.Scouts', array(
            $type,
            $location,
            $latitude,
            $longitude,
            $bookingDetails,
            $bookingURL,
        ));


        $thumbnail = new UploadField('ThumbnailImage', _t('ScoutDistrict.Events.THUMBNAIL', 'Thumbnail Image'));
        $thumbnail->setFolderName('event/thumbnail');
        $thumbnail->setRightTitle(_t(
            'ScoutDistrict.Events.THUMBNAIL_HELP',
            'A small image for displaying in listing/aggregated content'
        ))->addExtraClass('help');

        $image = new UploadField('Image', _t('ScoutDistrict.Events.IMAGE', 'Image'));
        $image->setFolderName('event/image');
        $image->setRightTitle(_t(
            'ScoutDistrict.Events.IMAGE_HELP',
            'A Larger image for displaying in event header'
        ))->addExtraClass('help');

        $files = new UploadField('Files', _t('ScoutDistrict.Events.FILE', 'Files'));
        $files->setFolderName('event/file');
        $files->setRightTitle(_t(
            'ScoutDistrict.Events.FILE_HELP',
            'This can be a file containing information about the event or an application form, etc'
        ))->addExtraClass('help');

        $fields->addFieldsToTab('Root.Files', array(
            $thumbnail,
            $image,
            $files,
        ));

        return $fields;
    }

    public function requireDefaultRecords()
    {
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

        if (!is_dir($root . '/assets/event/thumbnail')) {
            if (mkdir($root . '/assets/event/thumbnail', 0775, true)) {
                DB::alteration_message('Created Event Thumbnails Folder', 'created');
            }
        }

        if (!is_dir($root . '/assets/event/image')) {
            if (mkdir($root . '/assets/event/image', 0775, true)) {
                DB::alteration_message('Created Event Images Folder', 'created');
            }
        }

        if (!is_dir($root . '/assets/event/file')) {
            if (mkdir($root . '/assets/event/file', 0775, true)) {
                DB::alteration_message('Created Event Files Folder', 'created');
            }
        }
    }
}
