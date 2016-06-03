<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\ToggleMenus\Member;

use Xpressengine\ToggleMenu\AbstractToggleMenu as BaseToggleMenu;

/**
 * @category
 * @package     Xpressengine\ToggleMenus\Member
 */
abstract class UserToggleMenu extends BaseToggleMenu
{
    public static function getName()
    {
        return static::getComponentInfo('name');
    }

    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

}
