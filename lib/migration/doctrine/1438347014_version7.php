<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version7 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn( 'item', 'discount', 'decimal', 53, array('scale' => 10));
    }

    public function down()
    {
        $this->changeColumn( 'item', 'discount', 'decimal', 53, array('scale' => 2));
    }
}
