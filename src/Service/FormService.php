<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\CommonBundle\Service\Base\BaseService;

/**
 * Serves forms
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FormService extends BaseService
{
    /**
     * Information if HTML5 inline validation is disabled
     *
     * @var bool
     */
    private $novalidateDisabled;

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
     * Returns information if HTML5 inline validation is enabled
     *
     * @return bool
     */
    public function isHtml5ValidationEnabled(): bool
    {
        return false === $this->novalidateDisabled;
    }

    /**
     * Adds related to HTML5 inline validation options into the existing options.
     * If HTML5 inline validation is disabled, does nothing.
     *
     * Example of usage:
     * $formOptions = [];
     * $formService->addFormOptions($formOptions);
     * $form = $formFactory->create('', MyFormType::class, [], $formOptions);
     *
     * @param array $existingOptions (optional) Existing options
     */
    public function addFormOptions(array &$existingOptions = []): void
    {
        /*
         * HTML5 inline validation is enabled?
         * Nothing to do
         */
        if ($this->isHtml5ValidationEnabled()) {
            return;
        }

        /*
         * Let's add the "novalidate" attribute
         */
        if (!isset($existingOptions['attr'])) {
            $existingOptions['attr'] = [];
        }

        $existingOptions['attr']['novalidate'] = 'novalidate';
    }
}
