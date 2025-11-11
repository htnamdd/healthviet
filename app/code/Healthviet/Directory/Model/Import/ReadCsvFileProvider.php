<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\Import;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\ImportExport\Model\Import\Source\Csv;

class ReadCsvFileProvider
{
    /**
     * @var ComponentRegistrar
     */
    protected ComponentRegistrar $componentRegistrar;

    /**
     * @var ReadFactory
     */
    protected ReadFactory $readFactory;

    /**
     * @param ReadFactory $readFactory
     * @param ComponentRegistrar $componentRegistrar
     */
    public function __construct(ReadFactory $readFactory, ComponentRegistrar $componentRegistrar
    ) {
        $this->readFactory = $readFactory;
        $this->componentRegistrar = $componentRegistrar;
    }

    /**
     * Return data source
     *
     * @param string $fileName
     * @return Csv
     * @throws NoSuchEntityException
     */
    public function getSource(string $fileName): Csv
    {
        $filePath = $this->getPath($fileName);

        return new Csv($filePath, $this->getDirectoryRead());
    }

    /**
     * @return string $entityName
     * @throws NoSuchEntityException
     */
    protected function getPath(string $fileName): string
    {
        $moduleName = $this->getModuleName();
        $directoryRead = $this->getDirectoryRead();
        $moduleDir = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, $moduleName);
        $fileAbsolutePath = $moduleDir . '/Files/Import/' . $fileName . '.csv';

        $filePath = $directoryRead->getRelativePath($fileAbsolutePath);

        if (!$directoryRead->isFile($filePath)) {
            throw new NoSuchEntityException(__("There is no file: %file", ['file' => $filePath]));
        }

        return $filePath;
    }

    /**
     * @return ReadInterface
     */
    protected function getDirectoryRead(): ReadInterface
    {
        $moduleName = $this->getModuleName();
        $moduleDir = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, $moduleName);

        return $this->readFactory->create($moduleDir);
    }

    /**
     * @return string
     */
    protected function getModuleName(): string
    {
        return 'Healthviet_Directory';
    }
}
