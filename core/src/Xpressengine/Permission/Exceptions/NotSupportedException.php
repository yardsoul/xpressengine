<?php
/**
 * This file is not supported exception
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Permission\Exceptions;

use Xpressengine\Permission\PermissionException;

/**
 * 지원되지 않는 case 에 대한 exception
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 */
class NotSupportedException extends PermissionException
{
    protected $message = '":name" 은 지원되지 않습니다.';
}
