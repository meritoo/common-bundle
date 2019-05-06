<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Twig;

use function count;
use function is_iterable;
use function is_string;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Runtime class related to CommonExtension Twig Extension.
 * Required to create lazy-loaded Twig Extension.
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class CommonRuntime implements RuntimeExtensionInterface
{
    /**
     * Replacement of empty value
     *
     * @var string
     */
    private $emptyValueReplacement;

    /**
     * Class constructor
     *
     * @param string $emptyValueReplacement Replacement of empty value
     */
    public function __construct(string $emptyValueReplacement)
    {
        $this->emptyValueReplacement = $emptyValueReplacement;
    }

    /**
     * Verifies/Filters given value if is empty.
     * Returns replacement of empty value if given value is empty. Otherwise - given value.
     *
     * @param mixed       $value                 The value to check
     * @param null|string $emptyValueReplacement (optional) Custom replacement of empty value. If is set to null, the
     *                                           replacement is retrieved from configuration (default behaviour).
     * @return mixed
     */
    public function verifyEmptyValue($value, ?string $emptyValueReplacement = null)
    {
        $isNull = null === $value;
        $isEmptyIterable = false;
        $isEmptyString = false;

        // It's not null? Let's verify if it's empty iterable
        if (!$isNull && is_iterable($value)) {
            $isEmptyIterable = 0 === count($value);
        }

        // It's iterable, but not empty? Let's verify if it's empty string
        if (!$isEmptyIterable) {
            $isEmptyString = is_string($value) && '' === $value;
        }

        // Value is empty? Let's return the replacement of empty value
        if ($isNull || $isEmptyIterable || $isEmptyString) {
            if (null === $emptyValueReplacement) {
                $emptyValueReplacement = $this->emptyValueReplacement;
            }

            return $emptyValueReplacement;
        }

        return $value;
    }
}
