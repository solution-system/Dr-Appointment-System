<?php
$this->load->helper("my_helper");
?>

<form   name="frm_paypal"
        id="frm_paypal"
        action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" id="cmd" name="cmd" value="_xclick">
    <input type="hidden" id="business" name="business" value="<?= get_config_ext("palpal_address") ?>">
    <input type="hidden" id="" name="lc" value="US">
    <input type="hidden" id="item_name" name="item_name" value="<?= $item_name ?>">
    <input type="hidden" id="amount" name="amount" value="25.00">
    <input type="hidden" id="currency_code" name="currency_code" value="USD">
    <input type="hidden" id="button_subtype" name="button_subtype" value="services">
    <input type="hidden" id="no_note" name="no_note" value="1">
    <input type="hidden" id="no_shipping" name="no_shipping" value="1">
    <input type="hidden" id="rm" name="rm" value="1">
    <input type="hidden" id="return" name="return" value="<?= $return ?>">
    <input type="hidden" id="cancel_return" name="cancel_return" value="http://dr.solutionsystem.net/message/cancel">
    <input type="hidden" id="tax_rate" name="tax_rate" value="0.000">
    <input type="hidden" id="shipping" name="shipping" value="0.00">
    <input type="hidden" id="bn" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">

<!--<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">-->

</form>
<?php
if ($calid <> "")
    print '
<p align="center">
    <img src="/images/processing.gif" border="0">
</p>        
<script language="javascript">
window.setTimeout(afterDelay, 3000);

function afterDelay() {
    document.frm_paypal.submit();
}        
</script>';
?>