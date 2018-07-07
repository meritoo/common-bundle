<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Bundle;

use Meritoo\Common\Collection\Collection;

/**
 * Descriptors of bundles.
 * Collection used to store descriptors of all bundles.
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo.pl
 */
class Descriptors extends Collection
{
    /**
     * Returns descriptor of bundle that contains given class
     *
     * @param string $classNamespace Namespace of class for which descriptor of bundle should be returned
     * @return Descriptor|null
     */
    public function getDescriptor(string $classNamespace): ?Descriptor
    {
        if (!$this->isEmpty()) {
            /* @var $descriptor Descriptor */
            foreach ($this as $rootNamespace => $descriptor) {
                $rootNamespace = $descriptor->getRootNamespace();

                $doubleSlashed = str_replace('\\', '\\\\', $rootNamespace);
                $pattern = sprintf('|^%s\\.*|', $doubleSlashed);

                if (preg_match($pattern, $classNamespace)) {
                    return $descriptor;
                }
            }
        }

        return null;
    }

    /**
     * Returns descriptor of bundle with given name
     *
     * @param string $bundleName Name of bundle who descriptor should be returned
     * @return Descriptor|null
     */
    public function getDescriptorByName(string $bundleName): ?Descriptor
    {
        if (!$this->isEmpty()) {
            /* @var $descriptor Descriptor */
            foreach ($this as $rootNamespace => $descriptor) {
                $name = $descriptor->getName();

                if ($bundleName === $name) {
                    return $descriptor;
                }
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        if ($this->isEmpty()) {
            return [];
        }

        $array = [];

        /* @var $descriptor Descriptor */
        foreach ($this as $rootNamespace => $descriptor) {
            $array[$rootNamespace] = $descriptor->toArray();
        }

        return $array;
    }

    /**
     * Returns the descriptors created from given data
     *
     * @param array $data Data of descriptors
     * @return Descriptors
     */
    public static function fromArray(array $data): Descriptors
    {
        $descriptors = new static();

        if (!empty($data)) {
            foreach ($data as $descriptorData) {
                $descriptor = Descriptor::fromArray($descriptorData);
                $rootNamespace = $descriptor->getRootNamespace();

                $descriptors->add($descriptor, $rootNamespace);
            }
        }

        return $descriptors;
    }
}
