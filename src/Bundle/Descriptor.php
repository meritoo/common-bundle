<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Bundle;

use Meritoo\Common\Collection\StringCollection;
use Meritoo\Common\Utilities\Miscellaneous;
use Meritoo\Common\Utilities\Regex;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Descriptor of bundle
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class Descriptor
{
    /**
     * Path of directory with classes for the DataFixtures
     *
     * @var string
     */
    public const PATH_DATA_FIXTURES = 'DataFixtures/ORM';

    /**
     * Name of bundle
     *
     * @var string
     */
    private $name;

    /**
     * Short, simple name of bundle
     *
     * @var string
     */
    private $shortName;

    /**
     * Name of configuration root node of bundle
     *
     * @var string
     */
    private $configurationRootName;

    /**
     * Root namespace of bundle
     *
     * @var string
     */
    private $rootNamespace;

    /**
     * Physical path of bundle
     *
     * @var string
     */
    private $path;

    /**
     * Descriptor of the parent bundle
     *
     * @var null|Descriptor
     */
    private $parentBundleDescriptor;

    /**
     * Descriptor of the child bundle
     *
     * @var null|Descriptor
     */
    private $childBundleDescriptor;

    /**
     * Names of files with data fixtures from bundle
     *
     * @var StringCollection
     */
    private $dataFixtures;

    /**
     * Class constructor
     *
     * @param string          $name                   (optional) Name of bundle
     * @param string          $configurationRootName  (optional) Name of configuration root node of bundle
     * @param string          $rootNamespace          (optional) Root namespace of bundle
     * @param string          $path                   (optional) Physical path of bundle
     * @param null|Descriptor $parentBundleDescriptor (optional) Descriptor of the parent bundle
     * @param null|Descriptor $childBundleDescriptor  (optional) Descriptor of the child bundle
     */
    public function __construct(
        $name = '',
        $configurationRootName = '',
        $rootNamespace = '',
        $path = '',
        ?Descriptor $parentBundleDescriptor = null,
        ?Descriptor $childBundleDescriptor = null
    ) {
        $this->name = $name;
        $this->configurationRootName = $configurationRootName;
        $this->rootNamespace = $rootNamespace;
        $this->path = $path;
        $this->parentBundleDescriptor = $parentBundleDescriptor;
        $this->childBundleDescriptor = $childBundleDescriptor;

        $this->shortName = '';
        $this->dataFixtures = new StringCollection();
    }

    /**
     * Adds names of files with data fixtures from bundle
     *
     * @param array $fixturesPaths Names of files with data fixtures
     * @return Descriptor
     */
    public function addDataFixtures(array $fixturesPaths): Descriptor
    {
        if (!empty($fixturesPaths)) {
            foreach ($fixturesPaths as $path) {
                $this->dataFixtures->add($path);
            }
        }

        return $this;
    }

    /**
     * Creates and returns descriptor from given data
     *
     * @param array $data Data of descriptor
     * @return Descriptor
     */
    public static function fromArray(array $data): Descriptor
    {
        // Default values
        $name = '';
        $configurationRootName = '';
        $rootNamespace = '';
        $path = '';
        $parentBundleDescriptor = null;
        $childBundleDescriptor = null;

        // Grab values from provided array
        if (array_key_exists('name', $data) && !empty($data['name'])) {
            $name = $data['name'];
        }

        if (array_key_exists('configurationRootName', $data) && !empty($data['configurationRootName'])) {
            $configurationRootName = $data['configurationRootName'];
        }

        if (array_key_exists('rootNamespace', $data) && !empty($data['rootNamespace'])) {
            $rootNamespace = $data['rootNamespace'];
        }

        if (array_key_exists('path', $data) && !empty($data['path'])) {
            $path = $data['path'];
        }

        if (array_key_exists('parentBundleDescriptor', $data) && !empty($data['parentBundleDescriptor'])) {
            $parentData = $data['parentBundleDescriptor'];
            $parentBundleDescriptor = static::fromArray($parentData);
        }

        if (array_key_exists('childBundleDescriptor', $data) && !empty($data['childBundleDescriptor'])) {
            $childData = $data['childBundleDescriptor'];
            $childBundleDescriptor = static::fromArray($childData);
        }

        return new static(
            $name,
            $configurationRootName,
            $rootNamespace,
            $path,
            $parentBundleDescriptor,
            $childBundleDescriptor
        );
    }

    /**
     * Creates and returns descriptor of given bundle
     *
     * @param Bundle $bundle The bundle
     * @return Descriptor
     */
    public static function fromBundle(Bundle $bundle): Descriptor
    {
        // Values from bundle
        $name = $bundle->getName();
        $rootNamespace = $bundle->getNamespace();
        $path = $bundle->getPath();

        // Default values, not provided by bundle directly
        $configurationRootName = '';

        return new static($name, $configurationRootName, $rootNamespace, $path);
    }

    /**
     * Returns descriptor of the child bundle
     *
     * @return null|Descriptor
     */
    public function getChildBundleDescriptor(): ?Descriptor
    {
        return $this->childBundleDescriptor;
    }

    /**
     * Sets descriptor of the child bundle
     *
     * @param Descriptor $childBundleDescriptor (optional) The child's descriptor
     * @return Descriptor
     */
    public function setChildBundleDescriptor(?Descriptor $childBundleDescriptor): Descriptor
    {
        $this->childBundleDescriptor = $childBundleDescriptor;

        return $this;
    }

    /**
     * Returns name of configuration root node of bundle
     *
     * @return string
     */
    public function getConfigurationRootName(): string
    {
        return $this->configurationRootName;
    }

    /**
     * Sets name of configuration root node of bundle
     *
     * @param string $configurationRootName The name
     * @return Descriptor
     */
    public function setConfigurationRootName(string $configurationRootName): Descriptor
    {
        $this->configurationRootName = $configurationRootName;

        return $this;
    }

    /**
     * Returns names of files with data fixtures from bundle
     *
     * @return StringCollection
     */
    public function getDataFixtures(): StringCollection
    {
        return $this->dataFixtures;
    }

    /**
     * Returns real/full path of directory from bundle with classes for the DataFixtures
     *
     * @return null|string
     */
    public function getDataFixturesDirectoryPath(): ?string
    {
        $path = $this->getPath();

        if (empty($path)) {
            return null;
        }

        return Miscellaneous::concatenatePaths([
            $path,
            static::PATH_DATA_FIXTURES,
        ]);
    }

    /**
     * Returns name of bundle
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets name of bundle
     *
     * @param string $name The name
     * @return Descriptor
     */
    public function setName(string $name): Descriptor
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns descriptor of the parent bundle
     *
     * @return null|Descriptor
     */
    public function getParentBundleDescriptor(): ?Descriptor
    {
        return $this->parentBundleDescriptor;
    }

    /**
     * Sets descriptor of the parent bundle
     *
     * @param Descriptor $parentBundleDescriptor (optional) The parent's descriptor
     * @return Descriptor
     */
    public function setParentBundleDescriptor(?Descriptor $parentBundleDescriptor): Descriptor
    {
        $this->parentBundleDescriptor = $parentBundleDescriptor;

        return $this;
    }

    /**
     * Returns physical path of bundle
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Sets physical path of bundle
     *
     * @param string $path The path
     * @return Descriptor
     */
    public function setPath(string $path): Descriptor
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Returns root namespace of bundle
     *
     * @return string
     */
    public function getRootNamespace(): string
    {
        return $this->rootNamespace;
    }

    /**
     * Sets root namespace of bundle
     *
     * @param string $rootNamespace The root namespace
     * @return Descriptor
     */
    public function setRootNamespace(string $rootNamespace): Descriptor
    {
        $this->rootNamespace = $rootNamespace;

        return $this;
    }

    /**
     * Returns short, simple name of bundle
     *
     * @return string
     */
    public function getShortName(): string
    {
        if (empty($this->shortName)) {
            $name = strtolower($this->getName());
            $replaced = preg_replace('|bundle$|', '', $name);

            $this->shortName = trim($replaced);
        }

        return $this->shortName;
    }

    /**
     * Returns information if given file belongs to bundle
     *
     * @param string $filePath Path of file to verify
     * @return bool
     */
    public function hasFile(string $filePath): bool
    {
        return Regex::isSubPathOf($filePath, $this->getPath());
    }

    /**
     * Returns an array representation of the descriptor
     *
     * @param bool $withParentAndChild (optional) If is set to true, includes descriptor of the parent and child
     *                                 bundle (default behaviour). Otherwise - not.
     * @return array
     */
    public function toArray(bool $withParentAndChild = true): array
    {
        $array = [
            'name' => $this->getName(),
            'shortName' => $this->getShortName(),
            'configurationRootName' => $this->getConfigurationRootName(),
            'rootNamespace' => $this->getRootNamespace(),
            'path' => $this->getPath(),
            'dataFixtures' => $this->getDataFixtures()->toArray(),
        ];

        if ($withParentAndChild) {
            $parentDescriptor = $this->getParentBundleDescriptor();
            $childDescriptor = $this->getChildBundleDescriptor();

            if (null !== $parentDescriptor) {
                $array['parentBundleDescriptor'] = $parentDescriptor->toArray(false);
            }

            if (null !== $childDescriptor) {
                $array['childBundleDescriptor'] = $childDescriptor->toArray(false);
            }
        }

        return $array;
    }
}
