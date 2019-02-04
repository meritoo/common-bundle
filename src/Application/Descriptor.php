<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Application;

use Meritoo\Common\ValueObject\Version;

/**
 * Descriptor of application
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class Descriptor
{
    /**
     * Name of application
     *
     * @var string
     */
    private $name;

    /**
     * Description of application
     *
     * @var string
     */
    private $description;

    /**
     * Version of application
     *
     * @var null|Version
     */
    private $version;

    /**
     * Class constructor
     *
     * @param string       $name        Name of application
     * @param string       $description Description of application
     * @param null|Version $version     Version of application
     */
    public function __construct(string $name, string $description, ?Version $version)
    {
        $this->name = trim($name);
        $this->description = trim($description);
        $this->version = $version;
    }

    /**
     * Returns string representation of instance of this class
     *
     * @return string
     */
    public function __toString(): string
    {
        $name = $this->getName();
        $description = $this->getDescription();
        $version = $this->getVersion();

        if (empty($name)) {
            $name = '-';
        }

        if (empty($description)) {
            $description = '-';
        }

        if (null === $version) {
            $version = '-';
        }

        return sprintf('%s | %s | %s', $name, $description, $version);
    }

    /**
     * Returns name of application
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns description of application
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns version of application
     *
     * @return null|Version
     */
    public function getVersion(): ?Version
    {
        return $this->version;
    }
}
