<?php

/**
 * Unit form.
 *
 * @package    form
 * @subpackage Tax
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class UnitForm extends BaseUnitForm
{
    public function configure()
    {
        unset($this['items_list']);
        $this->widgetSchema['name']->setAttribute('class', 'name');
        $this->widgetSchema->setFormFormatterName('Xit');
    }
}