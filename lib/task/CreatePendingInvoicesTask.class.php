<?php

/**
 * Checks pending jobs on the recurring_invoice table
 *
 * @author JoeZ  <jzarate@gmail.com>
 */
class CreatePendingInvoicesTask extends sfDoctrineBaseTask
{
    protected function configure()
    {
        $this->addOptions(array(
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
            // Custom options
            new sfCommandOption('date', null, sfCommandOption::PARAMETER_REQUIRED, 'Date', sfDate::getInstance()->dump())
        ));

        $this->namespace = 'siwapp';
        $this->name = 'create-pending-invoices';
        $this->briefDescription = 'Generates all pending invoices';
        $this->detailedDescription = <<<EOF

The [create-pending-invoices|INFO] task checks the database and generates all pending invoices.
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        sfContext::createInstance(sfProjectConfiguration::getApplicationConfiguration('siwapp', 'prod', true));

        $invoices = RecurringInvoiceTable::createPendingInvoices();

        foreach ($invoices as $invoice) {
            $this->sendEmail($invoice);
        }

        $this->logSection('siwapp', 'Done');
    }

    /**
     * @param Invoice $invoice
     *
     * @return bool|false|int
     */
    protected function sendEmail(Invoice $invoice)
    {
        $result = false;

        try {
            $message = new InvoiceMessage($invoice);
            if ($message->getReadyState()) {
                $result = sfContext::getInstance()->getMailer()->sendNextImmediately()->send($message);
                if ($result) {
                    $invoice->setSentByEmail(true);
                    $invoice->save();
                }
            }
        } catch (Exception $e) {
            $this->logSection('siwapp', 'Unable to send recurring invoice mail: ' . $invoice->getCustomerEmail());
        }

        return $result;
    }
}