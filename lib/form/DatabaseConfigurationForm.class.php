<?php

/**
 * Database configuration form for the installer application.
 *
 * @package    siwapp
 * @subpackage form
 * @author     Enrique Martinez
 */
class DatabaseConfigurationForm extends BaseForm
{
    public function configure()
    {
        $myConnection = \Doctrine_Manager::getInstance()->getConnection('doctrine')->getOptions();
        $dsnInfo = $this->parseDsn($myConnection['dsn']);

        $this->setWidgets(array(
            'database' => new sfWidgetFormInputText(),
            'username' => new sfWidgetFormInputText(),
            'password' => new sfWidgetFormInputText(),
            'host' => new sfWidgetFormInputText(),
            'overwrite' => new sfWidgetFormInputCheckbox()
        ));

        $this->widgetSchema->setLabels(array(
            'database' => 'Database Name',
            'username' => 'User Name',
            'password' => 'Password',
            'host' => 'Database Host',
            'overwrite' => 'Overwrite previous Siwapp installations'
        ));

        $this->setDefaults(array(
            'database' => $dsnInfo['db_name'],
            'username' => $myConnection['username'],
            'host' => $dsnInfo['host'],
            'password' => $myConnection['password']
        ));

        $this->setValidators(array(
            'database' => new sfValidatorString(),
            'username' => new sfValidatorString(),
            'password' => new sfValidatorString(),
            'host' => new sfValidatorString(),
            'overwrite' => new sfValidatorPass()
        ));

        $this->validatorSchema->setPostValidator(new dbConnectionValidator());

        $this->widgetSchema->setNameFormat('db[%s]');
    }

    /**
     * Parse dsn info.
     *
     * @param string $dsn
     *
     * @return array
     */
    private function parseDsn($dsn)
    {
        $dsnArray = array();
        preg_match('/dbname=(\w+)/', $dsn, $dbname);
        $dsnArray['db_name'] = $dbname[1];
        preg_match('/host=(.*?);/', $dsn, $host);
        $dsnArray['host'] = $host[1];

        return $dsnArray;
    }
}
