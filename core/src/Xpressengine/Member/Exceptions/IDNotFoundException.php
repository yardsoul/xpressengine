<?php
/**
 * This file is already exists input mail address exception.
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Member\Exceptions;

use Xpressengine\Member\MemberException;

/**
 * ID 필드가 존재하지 않는 엔터티를 수정하거나 삭제하려고 할 때 발생하는 예외 클래스
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class IDNotFoundException extends MemberException
{
    protected $message = 'ID필드가 지정되어 있지 않습니다.';
}
