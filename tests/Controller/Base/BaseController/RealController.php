<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Controller\Base\BaseController;

use Meritoo\CommonBundle\Controller\Base\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Real controller used as instance of BaseController while running tests
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class RealController extends BaseController
{
    public function index(): Response
    {
        return new Response('<p>Cras Vestibulum</p>');
    }

    public function read(): RedirectResponse
    {
        return $this->redirectToReferer();
    }

    public function create(): RedirectResponse
    {
        return $this->redirectToRefererOrRoute('test.real_controller.index');
    }
}
