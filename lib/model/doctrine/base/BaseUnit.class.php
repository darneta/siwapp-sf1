<?php

/**
 * BaseTax
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property string $name
 * @property decimal $value
 * @property boolean $active
 * @property boolean $is_default
 * @property Doctrine_Collection $Items
 *
 * @method string              getName()       Returns the current record's "name" value
 * @method decimal             getValue()      Returns the current record's "value" value
 * @method boolean             getActive()     Returns the current record's "active" value
 * @method boolean             getIsDefault()  Returns the current record's "is_default" value
 * @method Doctrine_Collection getItems()      Returns the current record's "Items" collection
 * @method Tax                 setName()       Sets the current record's "name" value
 * @method Tax                 setValue()      Sets the current record's "value" value
 * @method Tax                 setActive()     Sets the current record's "active" value
 * @method Tax                 setIsDefault()  Sets the current record's "is_default" value
 * @method Tax                 setItems()      Sets the current record's "Items" collection
 *
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUnit extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('unit');
        $this->hasColumn('name', 'string', 50, array(
            'type' => 'string',
            'length' => 50,
        ));
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Item as Items', array(
            'refClass' => 'ItemTax',
            'local' => 'tax_id',
            'foreign' => 'item_id'));
    }
}