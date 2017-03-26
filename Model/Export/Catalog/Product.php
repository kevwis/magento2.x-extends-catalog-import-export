<?php
/**
 * Copyright © 2017 Kevwis. All rights reserved.
 */
namespace Kevwis\CatalogImportExport\Model\Export\Catalog;

use Magento\Catalog\Model\Product\LinkTypeProvider;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as ProductAttributesCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Option\CollectionFactory as ProductOptionCollectionFactory;
use Magento\Catalog\Model\ResourceModel\ProductFactory;
use Magento\CatalogImportExport\Model\Export\Product\Type\Factory;
use Magento\CatalogImportExport\Model\Export\RowCustomizerInterface;
use Magento\CatalogInventory\Model\ResourceModel\Stock\ItemFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory as AttributeSetCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\ImportExport\Model\Export\ConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;


class Product extends \Magento\CatalogImportExport\Model\Export\Product
{

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;


    /**
     * Product constructor.
     * @param TimezoneInterface $localeDate
     * @param Config $config
     * @param ResourceConnection $resource
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param CollectionFactory $collectionFactory
     * @param ConfigInterface $exportConfig
     * @param ProductFactory $productFactory
     * @param AttributeSetCollectionFactory $attrSetColFactory
     * @param CategoryCollectionFactory $categoryColFactory
     * @param ItemFactory $itemFactory
     * @param ProductOptionCollectionFactory $optionColFactory
     * @param ProductAttributesCollectionFactory $attributeColFactory
     * @param Factory $_typeFactory
     * @param LinkTypeProvider $linkTypeProvider
     * @param RowCustomizerInterface $rowCustomizer
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        TimezoneInterface $localeDate,
        Config $config,
        ResourceConnection $resource,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        CollectionFactory $collectionFactory,
        ConfigInterface $exportConfig,
        ProductFactory $productFactory,
        AttributeSetCollectionFactory $attrSetColFactory,
        CategoryCollectionFactory $categoryColFactory,
        ItemFactory $itemFactory,
        ProductOptionCollectionFactory $optionColFactory,
        ProductAttributesCollectionFactory $attributeColFactory,
        Factory $_typeFactory,
        LinkTypeProvider $linkTypeProvider,
        RowCustomizerInterface $rowCustomizer,
        ScopeConfigInterface $scopeConfig
    ) {

        parent::__construct(
            $localeDate,
            $config,
            $resource,
            $storeManager,
            $logger,
            $collectionFactory,
            $exportConfig,
            $productFactory,
            $attrSetColFactory,
            $categoryColFactory,
            $itemFactory,
            $optionColFactory,
            $attributeColFactory,
            $_typeFactory,
            $linkTypeProvider,
            $rowCustomizer
        );

        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    protected function _isAdvancedExportEnabled()
    {
        return (bool) $this->scopeConfig->getValue('kevwis_catalog_import_export/advanced_export_product/enabled');
    }

    /**
     * @return array
     */
    protected function _getExportExcludeAttrCodes()
    {
        return explode(',', $this->scopeConfig->getValue('kevwis_catalog_import_export/advanced_export_product/exclude_attributes'));
    }

    /**
     * @return array
     */
    protected function _getExportMainAttrCodes()
    {
        return array_diff(array_merge($this->_exportMainAttrCodes, $this->_getExportAttrCodes()), $this->_getExportExcludeAttrCodes());
    }
}
