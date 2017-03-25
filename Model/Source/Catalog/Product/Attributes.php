<?php
namespace Wsk\ImportExport\Model\Source\Catalog\Product;

use Magento\Catalog\Model\Config;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Attributes extends AbstractSource
{

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Config
     */
    private $catalogConfig;

    /**
     * @var CollectionFactory
     */
    private $attributeCollectionFactory;


    /**
     * Attributes constructor.
     * @param Config $catalogConfig
     * @param CollectionFactory $attributecollectionFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Config $catalogConfig,
        CollectionFactory $attributecollectionFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->catalogConfig = $catalogConfig;
        $this->attributeCollectionFactory = $attributecollectionFactory;
        $this->scopeConfig = $scopeConfig;
    }


    /**
     * @return array|null
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $attributeCollection = $this->attributeCollectionFactory->create();
            $this->_options = [];

            if ((bool) $this->scopeConfig->getValue('wsk_import_export/advanced_export_product/only_filterable_attributes')) {
                $attributeCollection->addIsFilterableFilter();
            }

            foreach ($attributeCollection as $attribute) {
                $this->_options[] = [
                    'label' => $attribute->getAttributeCode(),
                    'value' => $attribute->getAttributeCode()
                ];
            }
        }

        return $this->_options;
    }
}