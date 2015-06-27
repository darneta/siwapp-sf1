<?php

class UnitsForm extends FormsContainer
{
    public function __construct($options = array(), $CSRFSecret = null)
    {
        $this->old_units = Doctrine::getTable('Unit')->findAll();

        $forms = array();
        foreach ($this->old_units as $unit)
        {
            $forms['old_'.$unit->getId()] = new UnitForm($unit, $options, false);
        }
        parent::__construct($forms, 'UnitForm', $options, $CSRFSecret);
    }

    public function configure()
    {
        $this->widgetSchema->setNameFormat('units[%s]');
    }

}
