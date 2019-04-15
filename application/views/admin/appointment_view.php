<?php
$this->load->helper("my_helper");
?>
<script src="/include/js/calendar.js?<?=time()?>"></script>
<link rel="stylesheet" type="text/css" href="/include/css/calendar.css" />
<input type="hidden" value="<?= $doctor_id ?>" name="doctor_id" id="doctor_id">
<input type="hidden" value="<?= $this->session->userdata('user_id')?>" name="user_id" id="user_id">
<table border=1 align="center" width="100%">
    <form id="frm_dr" name="frm_dr" action="/admin/doctor/appointment/" method="post">
    <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
    <?php
    if ($this->session->userdata("user_type") <> "doctor")
        print '
        <tr>
            <td align="center">
                <strong>Doctor:</strong>' . get_dropdown('name', 'doctor', 'id', '', '', 'Add', $doctor_id) . '
            </td>
        </tr>'; ?>
    </form>
    <tr>
        <td align="center">
            <h1>Dr. <?= $doctor_name ?> Appointment Calendar</h1><br>
            <span id="msg"></span>
        </td>
    </tr>
    <tr>
        <td align="center">
            <table border=1 align="center" width="100%">                
                <tr>
                    <td align="center" width="100%">
                        <img src="/business_logo/thumbnail/<?= $business_logo ?>" border="0">
                    </td>
                    <td width="200" align="center">
                        <h1>Dr. <?= $doctor_name ?> Service(s)</h1>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <?php
                        echo $calendar;
                        ?>
                        <input type="hidden" id="month" name="month" value="<?= $month ?>">
                        <input type="hidden" id="year" name="year" value="<?= $year ?>">
                    </td>
                    <td align="center" valign="top">
                        <?php
                        if (is_array($services)) {
                            print '<table cellpadding=0 cellspacing=0><tr>
                                    <td height="30" nowrap><ul>';
                            $i = 0;
                            foreach ($services as $service):
                                print '<li>' . $service['name'] . ' Service</li>';
                            endforeach;
                            print '</ul></td>
                                </tr></table>';
                        }
                        ?>
                        <font color="red"><span id="error" class="error"></span></font>
                        <span id="frm_div">
                            <?php
                            include_once $_SERVER['DOCUMENT_ROOT'] . '/appointment_detail.php';
                            ?>
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
include_once realpath(APPPATH . '/views/frontend/paypal.php');
?>