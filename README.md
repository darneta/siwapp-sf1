siwapp-sf1
==========

Fork of [siwapp](https://github.com/siwapp/siwapp-sf1) with added dockerize support and additional features for lithuanian invoice requirements.

## Fork features
* Installer prefills default database config from databases.yml (dockerization support)
* Recurring invoices are automatically emailed out when generated (on cron job run)
* Add units to invoice items
* Pre-invoices (pre-invoice series)
* Custom email subject, text, filename
* 10 decimal points discount percent
