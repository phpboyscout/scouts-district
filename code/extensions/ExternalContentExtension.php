<?php
/**
 * ExternalBlogEntryExtension - code/extensions/ScoutCalenderExtension.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ExternalBlogEntryExtension Extension
 *
 * Class to Extend silverstripe-eventcalendar Calendars
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ExternalContentExtension extends DataExtension
{
    public function MetaTags(&$tags = "")
    {
        $page = $this->getOwner();
        if ($page && $page->ExternalLink) {
            $tags .= "<link rel=\"canonical\" href=\"{$page->ExternalLink}\" />\n";
        }
        return $tags;
    }
}
