<?php
/**
 * ParentDocumentNotFoundException
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Document\Exceptions;

use Xpressengine\Document\DocumentException;

/**
 * ParentDocumentNotFoundException
 *
 * @category    Document
 * @package     Xpressengine\Document
 */
class ParentDocumentNotFoundException extends DocumentException
{
    protected $message = 'Parent document not found.';
}
