<?php
/**
 * Template de administração do módulo
 *
 * Exibe o formulário para edição do módulo
 * @package pagseguro_opencart
 * @author ldmotta - ldmotta@gmail.com
 * @link motanet.com.br
 */
?>
<?php echo $header; ?>

<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
        <h1 style="background-image: url('view/image/payment.png');"><?php echo $heading_title; ?></h1>
        <div class="buttons">
            <a onclick="$('#form').submit();" class="button">
                <span><?php echo $button_save; ?></span></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button">
                <span><?php echo $button_cancel; ?></span></a>
        </div>
    </div>

    <div class="content">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
                <tr>
                    <td width="25%">
                        <span class="required">*</span>
                        <?php echo $lb_mail; ?>
                    </td>
                    <td>
                        <input type="text" name="pagseguro_mail" value="<?php echo $pagseguro_mail; ?>" />
                        <br />
                        <?php if ($error_pagseguro_mail): ?>
                        <span class="error"><?php echo $error_pagseguro_mail; ?></span>
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <td width="25%">
                        <span class="required">*</span>
                        <?php echo $lb_token; ?>
                    </td>
                    <td>
                        <input type="text" name="pagseguro_token" value="<?php echo $pagseguro_token; ?>" />
                    </td>
                </tr>
                <tr>
                    <td><?php echo $entry_order_status; ?></td>
                    <td><select name="pagseguro_order_status_id">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $pagseguro_order_status_id) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                        </select>
                    </td>
                </tr>                
                <tr>
                    <td width="25%">
                        <?php echo $lb_sort_order; ?>
                    </td>
                    <td>
                        <input type="text" name="pagseguro_sort_order" value="<?php echo $pagseguro_sort_order; ?>" size="3" />
                    </td>
                </tr>
                <tr>
                    <td><?php echo $lb_status; ?></td>
                    <td>
                        <select name="pagseguro_status">
                            <?php if ($pagseguro_status) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>
        <div>
            <h2><?php echo $instructions_title; ?></h2>

            <?php echo ControllerPaymentPagseguro::formatText($instructions_info); ?>

        </div>
    </div><!-- content -->

    <?php echo $footer; ?>
