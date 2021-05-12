<?php

namespace WolfSellers\Catalog\Setup;

use Magento\Variable\Model\VariableFactory;
use Symfony\Component\Config\Definition\Exception\Exception;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * @var VariableFactory
     */
    protected $_variableFactory;

    public function __construct(
        VariableFactory $variableFactory
    )
    {
        $this->_variableFactory = $variableFactory;
    }

    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(\Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $xmlDefaultStructure = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone= \"yes\"?>
<table>
	<columns>
		<column>
			<label></label>
			<category_id></category_id>
			<default>true</default>
		</column>
		<column>
			<category_id></category_id>
			<default>false</default>
		</column>
		<column>
			<label></label>
			<children>
				<column>
					<label></label>
					<category_id></category_id>
				</column>
				<column>
					<label></label>
					<category_id></category_id>
				</column>
			</children>
		</column>
	</columns>
</table>";

        $setup->startSetup();
        $variable = $this->_variableFactory->create();
        $data = [
            'code' => 'categories_table',
            'name' => 'Tabla categorias',
            'html_value' => '',
            'plain_value' => $xmlDefaultStructure,

        ];
        $variable->setData($data);

        try {
            $variable->save();
        } catch (Exception $exception) {
            //TODO add log
        }

        $setup->endSetup();
    }
}
