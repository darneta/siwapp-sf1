<?php

/**
 * Tax form base class.
 *
 * @method Tax getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUnitForm extends BaseFormDoctrine
{
    public function setup()
    {
        $this->setWidgets(array(
            'id'         => new sfWidgetFormInputHidden(),
            'name'       => new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
            'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
            'name'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
        ));

        $this->widgetSchema->setNameFormat('unit[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();

        parent::setup();
    }

    public function getModelName()
    {
        return 'Unit';
    }

    public function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();

        if (isset($this->widgetSchema['items_list']))
        {
            $this->setDefault('items_list', $this->object->Items->getPrimaryKeys());
        }

    }

    protected function doSave($con = null)
    {
        $this->saveItemsList($con);

        parent::doSave($con);
    }

    public function saveItemsList($con = null)
    {
        if (!$this->isValid())
        {
            throw $this->getErrorSchema();
        }

        if (!isset($this->widgetSchema['items_list']))
        {
            // somebody has unset this widget
            return;
        }

        if (null === $con)
        {
            $con = $this->getConnection();
        }

        $existing = $this->object->Items->getPrimaryKeys();
        $values = $this->getValue('items_list');
        if (!is_array($values))
        {
            $values = array();
        }

        $unlink = array_diff($existing, $values);
        if (count($unlink))
        {
            $this->object->unlink('Items', array_values($unlink));
        }

        $link = array_diff($values, $existing);
        if (count($link))
        {
            $this->object->link('Items', array_values($link));
        }
    }

}
