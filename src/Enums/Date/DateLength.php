<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Enums\Date;

enum DateLength: string
{
    case Date = 'date';
    case DateTime = 'datetime';
    case Time = 'time';
}
