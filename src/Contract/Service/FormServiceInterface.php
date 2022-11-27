<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\Service;

use Symfony\Component\Form\FormInterface;

/**
 * Interface/Contract of service that serves forms
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface FormServiceInterface
{
    public function addHtml5ValidationOptions(array &$existingOptions = []): void;

    /**
     * Returns errors as simple key-value array
     *
     * @param FormInterface $form A form with validation errors
     * @return array
     */
    public function errorsToArray(FormInterface $form): array;

    public function isHtml5ValidationEnabled(): bool;
}
