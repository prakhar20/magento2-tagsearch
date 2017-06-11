<?php
namespace Codilar\ProductTags\Setup;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        //START: install stuff
        //END:   install stuff
        
//Create Tags Table
        $table = $installer->getConnection()->newTable(
                    $installer->getTable('codilar_producttags_tags')
            )->addColumn(
                    'tag_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ],
                    'Tag ID'
                )->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [ 'nullable' => false, ],
                    'Title'
                )->addColumn(
                    'created_by',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'nullable' => true, 'default' =>null,'unsigned'=>true],
                    'Created By Customer'
                )->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [ 'nullable' => false, 'default' => '0', ],
                    'Status'
                )->addColumn(
                    'creation_time',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [ 'nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,],
                    'Creation Time'
                )->addForeignKey(
                        $installer->getFkName(
                            'codilar_producttags_tags',
                            'created_by',
                            'customer_entity',
                            'entity_ids'
                        ),
                        'created_by',
                        $installer->getTable('customer_entity'), 
                        'entity_id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
                );

        $installer->getConnection()->createTable($table);
        //END   table setup

        /**
        Create Product Mapping 
        **/
        $table = $installer->getConnection()->newTable(
                    $installer->getTable('tag_relation')
                )->addColumn(
                    'value_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ],
                    'value ID'
                )->addColumn(
                    'tag_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'nullable' => false, 'unsigned' => true ],
                    'Tag ID'
                )->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'nullable' => false, 'unsigned' => true,],
                    'Product ID'
                )->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'nullable' => false,'unsigned' => true,],
                    'Customer ID'
                )->addColumn(
                    'creation_time',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [ 'nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,],
                    'Creation Time'
                )->addIndex($installer->getIdxName('tag_relation', array('tag_id', 'customer_id', 'product_id'), \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE),array('tag_id', 'customer_id', 'product_id',), array('type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE)
                )->addIndex($installer->getIdxName('tag_relation', 
                            array('product_id')),
                            array('product_id')
                )->addIndex($installer->getIdxName('tag_relation',
                            array('tag_id')),
                            array('tag_id')
                )->addIndex($installer->getIdxName('tag_relation',
                            array('customer_id')),
                            array('customer_id')
                )->addForeignKey($installer->getFkName('tag_relation',
                            'customer_id', 
                            'customer_entity',
                            'entity_id'),
                            'customer_id', 
                            $installer->getTable('customer_entity'),
                            'entity_id',
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->addForeignKey($installer->getFkName('tag_relation',
                            'product_id',
                            'catalog_product_entity',
                            'entity_id'),
                            'product_id', 
                            $installer->getTable('catalog_product_entity'),
                            'entity_id',
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->addForeignKey($installer->getFkName('tag_relation', 
                            'tag_id', 
                            'codilar_producttags_tags', 
                            'tag_id'),
                            'tag_id', 
                            $installer->getTable('codilar_producttags_tags'), 
                            'tag_id',
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                );
                $installer->getConnection()->createTable($table);
                $installer->endSetup();     
                //end Creating Product Mapping
    }
}
