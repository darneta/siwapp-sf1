<?php use_helper('jQuery', 'JavascriptBase')?>
<span id="tax_<?php echo $rowId?>">
    <select class="observable tax" id="item_taxes_list_<?php echo $rowId?>" name="invoice[Items][<?php echo $rowId?>][unit]">
        <?php
        $taxes = Doctrine::getTable('Unit')->findAll();
        foreach($taxes as $o_tax):?>
            <option value="<?php echo $o_tax->name?>" <?php echo $o_tax->name == $unitName ? 'selected="selected"':''?>>
                <?php echo $o_tax->name?>
            </option>
        <?php endforeach?>
    </select>
</span>
