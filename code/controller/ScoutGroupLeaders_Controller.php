<?php
/**
 * ScoutGroupLeaders_Controller - code/extensions/ScoutGroupLeaders_Controller.php
 *
 * @link      http://github.com/zucchi/Silverstripe-ScoutDistrict for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

/**
 * ScoutGroupLeaders Controller
 *
 * Controller to display ScoutGroupLeaders
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
class ScoutGroupLeaders_Controller extends Page_Controller
{
    public function Leaders()
    {
        $leaders = $this->dataRecord->Leaders();

        return $leaders;
    }
} 