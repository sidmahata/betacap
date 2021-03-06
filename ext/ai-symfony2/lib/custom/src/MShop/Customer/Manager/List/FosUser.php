<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MShop
 * @subpackage Customer
 */


/**
 * Fos user bundle implementation of the customer list class.
 *
 * @package MShop
 * @subpackage Customer
 */
class MShop_Customer_Manager_List_FosUser
	extends MShop_Customer_Manager_List_Default
	implements MShop_Customer_Manager_List_Interface, MShop_Common_Manager_List_Interface
{
	private $_searchConfig = array(
		'customer.list.id'=> array(
			'code'=>'customer.list.id',
			'internalcode'=>'fosli."id"',
			'internaldeps' => array( 'LEFT JOIN "fos_user_list" AS fosli ON ( fos."id" = fosli."parentid" )' ),
			'label'=>'Customer list ID',
			'type'=> 'integer',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_INT,
			'public' => false,
		),
		'customer.list.siteid'=> array(
			'code'=>'customer.list.siteid',
			'internalcode'=>'fosli."siteid"',
			'label'=>'Customer list site ID',
			'type'=> 'integer',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_INT,
			'public' => false,
		),
		'customer.list.parentid'=> array(
			'code'=>'customer.list.parentid',
			'internalcode'=>'fosli."parentid"',
			'label'=>'Customer list parent ID',
			'type'=> 'integer',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_INT,
			'public' => false,
		),
		'customer.list.domain'=> array(
			'code'=>'customer.list.domain',
			'internalcode'=>'fosli."domain"',
			'label'=>'Customer list domain',
			'type'=> 'string',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.list.typeid' => array(
			'code'=>'customer.list.typeid',
			'internalcode'=>'fosli."typeid"',
			'label'=>'Customer list type ID',
			'type'=> 'integer',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_INT,
			'public' => false,
		),
		'customer.list.refid'=> array(
			'code'=>'customer.list.refid',
			'internalcode'=>'fosli."refid"',
			'label'=>'Customer list reference ID',
			'type'=> 'string',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.list.datestart' => array(
			'code'=>'customer.list.datestart',
			'internalcode'=>'fosli."start"',
			'label'=>'Customer list start date/time',
			'type'=> 'datetime',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.list.dateend' => array(
			'code'=>'customer.list.dateend',
			'internalcode'=>'fosli."end"',
			'label'=>'Customer list end date/time',
			'type'=> 'datetime',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.list.config' => array(
			'code'=>'customer.list.config',
			'internalcode'=>'fosli."config"',
			'label'=>'Customer list position',
			'type'=> 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.list.position' => array(
			'code'=>'customer.list.position',
			'internalcode'=>'fosli."pos"',
			'label'=>'Customer list position',
			'type'=> 'integer',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_INT,
		),
		'customer.list.status' => array(
			'code'=>'customer.list.status',
			'internalcode'=>'fosli."status"',
			'label'=>'Customer list status',
			'type'=> 'integer',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_INT,
		),
		'customer.list.ctime'=> array(
			'code'=>'customer.list.ctime',
			'internalcode'=>'fosli."ctime"',
			'label'=>'Customer list create date/time',
			'type'=> 'datetime',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.list.mtime'=> array(
			'code'=>'customer.list.mtime',
			'internalcode'=>'fosli."mtime"',
			'label'=>'Customer list modification date/time',
			'type'=> 'datetime',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.list.editor'=> array(
			'code'=>'customer.list.editor',
			'internalcode'=>'fosli."editor"',
			'label'=>'Customer list editor',
			'type'=> 'string',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_STR,
		),
	);


	/**
	 * Removes old entries from the storage.
	 *
	 * @param array $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
		$path = 'classes/customer/manager/list/submanagers';
		foreach( $this->_getContext()->getConfig()->get( $path, array( 'type' ) ) as $domain ) {
			$this->getSubManager( $domain )->cleanup( $siteids );
		}

		$this->_cleanup( $siteids, 'mshop/customer/manager/list/fosuser/item/delete' );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing MW_Common_Criteria_Attribute_Interface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'classes/customer/manager/list/submanagers';

		return $this->_getSearchAttributes( $this->_searchConfig, $path, array( 'type' ), $withsub );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return mixed Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( $manager, $name = null )
	{
		return $this->_getSubManager( 'customer', 'list/' . $manager, ( $name === null ? 'FosUser' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/list/type/fosuser/item/)
	 */
	protected function _getConfigPath()
	{
		return 'mshop/customer/manager/list/fosuser/item/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function _getSearchConfig()
	{
		return $this->_searchConfig;
	}
}
