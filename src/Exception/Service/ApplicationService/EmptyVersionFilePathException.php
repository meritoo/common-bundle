<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Service\ApplicationService;

use RuntimeException;

/**
 * An exception used while path of a file, who contains version of the application, is empty
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class EmptyVersionFilePathException extends RuntimeException
{
    /**
     * Creates exception
     *
     * @return EmptyVersionFilePathException
     */
    public static function create(): EmptyVersionFilePathException
    {
        return new static('Path of a file, who contains version of the application, is empty. Is there everything ok?');
    }
}
