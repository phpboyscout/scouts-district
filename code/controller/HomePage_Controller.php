<?php
/**
 * Homepage - code/extensions/Homepage.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * Homepage Controller
 *
 * Controller to display Homepage
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class HomePage_Controller extends Page_Controller
{
    public function TagLink()
    {
        if ($this->TagLink) {
            return DataObject::get_by_id('SiteTree', $this->TagLink)->Link();
        }
        return false;
    }

    /**
     * Get the next event or return false if there is none.
     *
     * @return bool|Event
     */
    public function NextEvent()
    {
        if ($id = $this->dataRecord->Calendar) {
            if ($calendar = DataObject::get_by_id('Calendar', $id)) {
                $entries =  $calendar->UpcomingEvents(1);
                return $entries->first();
            }
        }
        return false;
    }

    /**
     * Get the upcoming event after the next event
     * or return false if there is none.
     *
     * @return bool|Event
     */
    public function UpcomingEvent() {

        if ($id = $this->dataRecord->Calendar) {
            if ($calendar =DataObject::get_by_id('Calendar', $id)) {
                $entries =  $calendar->UpcomingEvents(2);
                return $entries[1];
            }
        }

        return false;

    }

    /**
     * Get the upcoming event after the next event
     * or return false if there is none.
     *
     * @return bool|ArrayList
     */
    public function CalendarEvents() {

        if ($id = $this->dataRecord->Calendar) {
            if ($calendar = DataObject::get_by_id('Calendar', $id)) {
                $entries =  $calendar->UpcomingEvents(5);
                return $entries;
            }
        }

        return false;
    }

    /**
     * Get the upcoming event after the next event
     * or return false if there is none.
     *
     * @return bool|BlogEntry
     */
    public function LatestNews()
    {
        if ($id = $this->dataRecord->BlogHolder) {
            if ($holder = DataObject::get_by_id('SiteTree', $id)) {
                $entries =  $holder->Entries(3);
                return $entries;
            }
        }

        return false;
    }

    /**
     * Get the upcoming event after the next event
     * or return false if there is none.
     *
     * @return bool|BlogEntry
     */
    public function InfoPanelPage()
    {
        if ($id = $this->dataRecord->InfoPanelPage) {
            if ($page = DataObject::get_by_id('SiteTree', $id)) {
                return $page;
            }
        }

        return false;
    }
}