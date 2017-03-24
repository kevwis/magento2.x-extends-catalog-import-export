<?php
namespace Wsk\ImportExport\Model\Source\Catalog\Product;

use Magento\Catalog\Model\Config;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Attributes extends AbstractSource
{

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
     */
    public function __construct(
        Config $catalogConfig,
        CollectionFactory $attributecollectionFactory)
    {
        $this->catalogConfig = $catalogConfig;
        $this->attributeCollectionFactory = $attributecollectionFactory;
    }


    /**
     * @return array|null
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $attributeCollection = $this->attributeCollectionFactory->create();
            $this->_options = [];

            # $attributeCollection->addIsFilterableFilter();
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