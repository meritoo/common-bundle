<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Twig;

use Meritoo\CommonBundle\Service\FormService;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Runtime class related to FormExtension Twig Extension.
 * Required to create lazy-loaded Twig Extension.
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FormRuntime implements RuntimeExtensionInterface
{
    /**
     * Serves forms
     *
     * @var FormService
     */
    private FormService $formService;

    /**
     * Class constructor
     *
     * @param FormService $formService Serves forms
     */
    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * Returns information if HTML5 inline validation is enabled
     *
     * @return bool
     */
    public function isHtml5ValidationEnabled(): bool
    {
        return $this->formService->isHtml5ValidationEnabled();
    }
}
