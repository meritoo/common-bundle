<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\CommonBundle\Contract\Service\FormServiceInterface;
use Meritoo\CommonBundle\Service\Base\BaseService;
use Symfony\Component\Form\FormInterface;

/**
 * Serves forms
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FormService extends BaseService implements FormServiceInterface
{
    /**
     * Information if HTML5 inline validation is disabled
     *
     * @var bool
     */
    private bool $novalidateDisabled;

    /**
     * Class constructor
     *
     * @param bool $novalidateDisabled Information if HTML5 inline validation is disabled
     */
    public function __construct(bool $novalidateDisabled)
    {
        $this->novalidateDisabled = $novalidateDisabled;
    }

    /**
     * @param array $existingOptions
     * @deprecated since meritoo/common-bundle 0.2.8, use "addHtml5ValidationOptions()" instead
     */
    public function addFormOptions(array &$existingOptions = []): void
    {
        trigger_deprecation(
            'meritoo/common-bundle',
            '0.2.8',
            'The "%s()" method is deprecated, use "addHtml5ValidationOptions()" instead.',
            __METHOD__
        );
    }

    /**
     * Adds related to HTML5 inline validation options into the existing options.
     * If HTML5 inline validation is disabled, does nothing.
     *
     * Example of usage:
     * $formOptions = [];
     * $formService->addHtml5ValidationOptions($formOptions);
     * $form = $formFactory->create('', MyFormType::class, [], $formOptions);
     *
     * @param array $existingOptions (optional) Existing options
     */
    public function addHtml5ValidationOptions(array &$existingOptions = []): void
    {
        if ($this->isHtml5ValidationEnabled()) {
            return;
        }

        // Let's add the "novalidate" attribute
        $existingOptions['attr']['novalidate'] = 'novalidate';
    }

    /**
     * Returns information if HTML5 inline validation is enabled
     *
     * @return bool
     */
    public function isHtml5ValidationEnabled(): bool
    {
        return false === $this->novalidateDisabled;
    }

    public function errorsToArray(FormInterface $form): array
    {
        if ($form->isValid()) {
            return [];
        }

        $result = [];
        $formName = $form->getName();
        $globalErrors = $form->getErrors();

        // Global
        foreach ($globalErrors as $error) {
            $result[$formName][] = $error->getMessage();
        }

        // Fields
        foreach ($form as $child) {
            /** @var FormInterface $child */
            if ($child->isValid()) {
                continue;
            }

            $childName = $child->getName();
            $childErrors = $child->getErrors();

            foreach ($childErrors as $error) {
                $result[$childName][] = $error->getMessage();
            }
        }

        return $result;
    }
}
