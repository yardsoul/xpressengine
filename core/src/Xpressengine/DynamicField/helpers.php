<?php
/**
 * DynamicField function.
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

if (function_exists('df') === false) {
    /**
     * @param string $group      group name
     * @param string $columnName dynamic field id
     * @return \Xpressengine\DynamicField\AbstractType
     */
    function df($group, $columnName)
    {
        return \XeDynamicField::get($group, $columnName);
    }
}

if (function_exists('dfCreate') === false) {
    /**
     * @param string $group      group name
     * @param string $columnName dynamic field id
     * @param array  $args       arguments
     * @return string
     */
    function dfCreate($group, $columnName, $args)
    {
        $fieldType = df($group, $columnName);
        if ($fieldType == null) {
            return '';
        }
        return $fieldType->getSkin()->create($args);

    }
}

if (function_exists('dfEdit') === false) {
    /**
     * @param string $group      group name
     * @param string $columnName dynamic field id
     * @param array  $args       arguments
     * @return string
     */
    function dfEdit($group, $columnName, $args)
    {
        $fieldType = df($group, $columnName);
        if ($fieldType == null) {
            return '';
        }
        return $fieldType->getSkin()->edit($args);
    }
}
