<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Bundle;

use Meritoo\Common\Collection\BaseCollection;

/**
 * Descriptors of bundles.
 * Collection used to store descriptors of all bundles.
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class Descriptors extends BaseCollection
{
    /**
     * Returns the descriptors created from given data
     *
     * @param array $data Data of descriptors
     * @return Descriptors
     */
    public static function fromArray(array $data): Descriptors
    {
        $result = new self();

        if (!empty($data)) {
            $descriptors = [];

            foreach ($data as $descriptorData) {
                $descriptors[] = Descriptor::fromArray($descriptorData);
            }

            $result->addMultiple($descriptors, true);
        }

        return $result;
    }

    /**
     * Returns descriptor of bundle that contains given class
     *
     * @param string $classNamespace Namespace of class for which descriptor of bundle should be returned
     * @return null|Descriptor
     */
    public function getDescriptor(string $classNamespace): ?Descriptor
    {
        if (!$this->isEmpty()) {
            /** @var Descriptor $descriptor */
            foreach ($this as $descriptor) {
                $rootNamespace = $descriptor->getRootNamespace();

                if ('' === $rootNamespace) {
                    if ($classNamespace === $rootNamespace) {
                        return $descriptor;
                    }

                    continue;
                }

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
     * @return null|Descriptor
     */
    public function getDescriptorByName(string $bundleName): ?Descriptor
    {
        if (!$this->isEmpty()) {
            /** @var Descriptor $descriptor */
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

        /** @var Descriptor $descriptor */
        foreach ($this as $rootNamespace => $descriptor) {
            $array[$rootNamespace] = $descriptor->toArray();
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    protected function isValidType($element): bool
    {
        return $element instanceof Descriptor;
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareElements(array $elements): array
    {
        if (empty($elements)) {
            return [];
        }

        $result = [];

        /** @var Descriptor $element */
        foreach ($elements as $element) {
            $rootNamespace = $element->getRootNamespace();

            // If root namespace is unknown, use 0-based index
            if ($rootNamespace === '') {
                $result[] = $element;
                continue;
            }

            $result[$rootNamespace] = $element;
        }

        return $result;
    }
}
