<?php

namespace WolfSellers\Catalog\Block\Product\ProductList;

use \Magento\Framework\View\Element\Template;
use \Magento\Variable\Model\VariableFactory;
use \Magento\Catalog\Api\CategoryRepositoryInterface;

class Table extends Template
{
    const TABLE_STRUCTURE = "table_structure";
    const PROPERTY_COLUMNS = "columns";
    const PROPERTY_COLUMN = "column";
    const PROPERTY_COLUMN_ITEM_LABEL = "label";
    const PROPERTY_COLUMN_ITEM_CATEGORY_ID = "category_id";
    const PROPERTY_COLUMN_ITEM_CHILDREN = "children";
    const EMPTY_COLUMNS = 0;
    const PROPERTY_DEFAULT = 'default';
    const KEY_ITEMS = 'items';
    const KEY_DEFAULT_CATEGORY = 'default_category_id';
    const DEFAULT_CATEGORY_INDEX = 0;

    protected $_variable;

    private $_dom = null;

    /**
     * @var VariableFactory
     */
    protected $_variableFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $_categoryRepository;

    /**
     * @var string
     */
    protected $_template = 'WolfSellers_Catalog::product/list/table.phtml';

    public function __construct(
        Template\Context $context,
        VariableFactory $variableFactory,
        CategoryRepositoryInterface $categoryRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_variableFactory = $variableFactory;
        $this->_categoryRepository = $categoryRepository;
    }

    public function getStructure()
    {
        $tableStructure = [];
        $variable = $this->_variableFactory->create();
        $customVariableCode = (string)$this->getData(self::TABLE_STRUCTURE);
        $this->_variable = $variable->loadByCode($customVariableCode);

        $variableValue = $this->_variable->getValue('plain');
        $this->_dom = simplexml_load_string($variableValue);
        if (!$this->_dom) {
            return $tableStructure;
        }

        if (!$this->_validateProperties()) {
            return $tableStructure;
        }

        $index = 0;
        $defaultCategoryId = "";
        foreach ($this->_dom->columns->column as $columnItem) {
            $_categoryId = (string)$columnItem->category_id;

            $categoryReference = $this->_categoryExist($_categoryId);
            if (!$categoryReference) {
                continue;
            }

            $_label = (string)$columnItem->label;
            if (property_exists($columnItem, self::PROPERTY_DEFAULT) && (string)$columnItem->default == 'true') {
                $defaultCategoryId = $_categoryId;
            }

            $_label = ($_label != "") ? $_label : $categoryReference->getName();
            $tableStructure[self::KEY_ITEMS][$index] = [
                self::PROPERTY_COLUMN_ITEM_LABEL => $_label,
                self::PROPERTY_COLUMN_ITEM_CATEGORY_ID => $_categoryId
            ];

            if (property_exists($columnItem, self::PROPERTY_COLUMN_ITEM_CHILDREN) &&
                $columnItem->children->count() > self::EMPTY_COLUMNS) {
                foreach ($columnItem->children->column as $subCategory) {
                    $childrenOptions = [
                        self::PROPERTY_COLUMN_ITEM_LABEL => (string)$subCategory->label,
                        self::PROPERTY_COLUMN_ITEM_CATEGORY_ID => (string)$subCategory->category_id
                    ];

                    $tableStructure[self::KEY_ITEMS][$index][self::PROPERTY_COLUMN_ITEM_CHILDREN][] = $childrenOptions;
                }
            }
            $index++;
        }

        if (empty($tableStructure)) {
            return $tableStructure;
        }

        if ($defaultCategoryId == "" && !empty($tableStructure)) {
            $defaultCategoryId = $tableStructure[self::KEY_ITEMS][self::DEFAULT_CATEGORY_INDEX][self::PROPERTY_COLUMN_ITEM_CATEGORY_ID];
        }
        $tableStructure[self::KEY_DEFAULT_CATEGORY] = $defaultCategoryId;
        return $tableStructure;
    }

    private function _categoryExist($categoryId)
    {
        try {
            return $this->_categoryRepository->get($categoryId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            //TODO add log
            return null;
        }
    }

    private function _validateProperties()
    {
        return (property_exists($this->_dom, self::PROPERTY_COLUMNS) &&
            property_exists($this->_dom->columns, self::PROPERTY_COLUMN) &&
            $this->_dom->columns->count() > self::EMPTY_COLUMNS
        );
    }
}
