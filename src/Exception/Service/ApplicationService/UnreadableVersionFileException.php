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
 * An exception used while file, who contains version of the application, is not readable
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class UnreadableVersionFileException extends RuntimeException
{
    /**
     * Creates exception
     *
     * @param string $filePath Path of a file who contains version of the application
     * @return UnreadableVersionFileException
     */
    public static function create(string $filePath): UnreadableVersionFileException
    {
        $template = 'File %s, who contains version of the application, is not readable. Does the file exist?';
        $message = sprintf($template, $filePath);

        return new self($message);
    }
}
