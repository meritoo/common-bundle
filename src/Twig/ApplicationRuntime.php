<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Twig;

use Meritoo\CommonBundle\Application\Descriptor;
use Meritoo\CommonBundle\Service\ApplicationService;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Runtime class related to ApplicationExtension Twig Extension.
 * Required to create lazy-loaded Twig Extension.
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class ApplicationRuntime implements RuntimeExtensionInterface
{
    /**
     * Serves application
     *
     * @var ApplicationService
     */
    private ApplicationService $applicationService;

    /**
     * Class constructor
     *
     * @param ApplicationService $applicationService Serves application
     */
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * Returns descriptor of application
     *
     * @return Descriptor
     */
    public function getDescriptor(): Descriptor
    {
        return $this->applicationService->getDescriptor();
    }
}
