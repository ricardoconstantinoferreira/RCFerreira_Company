<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\Block;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use RCFerreira\Company\Model\ResourceModel\Company\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \RCFerreira\Company\Model\ResourceModel\Company\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $blockCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $inventory) {
            $this->loadedData[$inventory->getId()] = $inventory->getData();
        }

        $data = $this->dataPersistor->get('index');
        if (!empty($data)) {
            $inventory = $this->collection->getNewEmptyItem();
            $inventory->setData($data);
            $this->loadedData[$inventory->getId()] = $inventory->getData();
            $this->dataPersistor->clear('index');
        }

        return $this->loadedData;
    }
}
