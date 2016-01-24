<?php
/**
 * ScoutEventFile - code/model/ScoutEventFile.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutEventFile Model
 *
 * Class to define files for attachment to a Scout Event
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */

class ScoutEventFile extends File
{

    private static $has_one = array(
        'CalendarEvent' => 'CalendarEvent',

    );

    /**
     * Return an XHTML img tag for this Image.
     *
     * @return string
     */
    public function forTemplate()
    {
        return $this->getTag();
    }

    /**
     * Return an XHTML img tag for this Image,
     * or NULL if the image file doesn't exist on the filesystem.
     *
     * @return string
     */
    public function getTag()
    {
        if (file_exists(Director::baseFolder() . '/' . $this->Filename)) {
            $url = $this->getURL();
            $title = ($this->Title) ? $this->Title : $this->Filename;
            if ($this->Title) {
                $title = Convert::raw2att($this->Title);
            } else {
                if (preg_match("/([^\/]*)\.[a-zA-Z0-9]{1,6}$/", $title, $matches)) {
                    $title = Convert::raw2att($matches[1]);
                }
            }
            return "<a hret=\"$url\" title=\"$title\" >$title</a>";
        }
    }
}
