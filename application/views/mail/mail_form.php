<style>

  td {
    padding-bottom: 1em;
  }

</style>
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading" align="center"><strong>Mail Form</strong></div>
        <input type="hidden" name="errorVal" value="0">
            <form action="" method="post" style="margin-top:20px">
                <table border="0" align="center" width="95%">
                    <tr>
                        <td width="10%"></td><td width="90%"></td>
                    </tr>
                    <tr>
                        <td>To :</td>
                        <td>
                            <input class="form-control" type="text" name="to" />
                        </td>
                    </tr>
                    <tr>
                        <td>Subject :</td> 
                        <td>
                            <input class="form-control" type="text" name="subject" value="Daily Attendance report as of <?php echo date("F j".", "."Y "."("."h:i A".")"); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Body :</td>
                        <td>
                            <div id="email_body" contenteditable="true" class="content" style="border: 1px gray solid; height: auto; padding:0px 10px 0px 10px">
                              <br/><br/>

                              Dear All,<br /><br /><br /> 
                              
                              <?php if (!empty($report_table)) {
                                echo $report_table; 
                              } ?>  <br /><br />

                              Please be informed of the following employee notifications for today:<br/><br/>

                              <?php if (!empty($message_leave)) {
                                echo '<span style="font-size: 16px;"><b><u>LEAVE</u></b><br /><br /></span>';
                                echo $message_leave.'<br /><br />';

                              } ?>

                              <?php if (!empty($message_late)) {
                                echo '<span style="font-size: 16px;"><b><u>LATE with NOTIFICATION</u></b><br /><br /></span>';
                                echo $message_late.'<br /><br />';
                              } ?>

                              <?php if (!empty($message_no_notif_late)) {
                                echo '<span style="font-size: 16px;"><b><u>LATE without NOTIFICATION</u></b><br /><br /></span>';
                                echo $message_no_notif_late.'<br /><br />';
                              } ?>

                              <?php if (!empty($message_absent)) {
                                echo '<span style="font-size: 16px;"><b><u>ABSENT</u></b><br /><br /></span>';
                                echo $message_absent.'<br /><br />';
                              } ?>

                              <?php if (!empty($message_awol)) {
                                echo '<span style="font-size: 16px;"><b><u>AWOL</u></b><br /><br /></span>';
                                echo $message_awol.'<br /><br />';
                              } ?>

                              --</br>
                              <div style="font-family:monospace;">Best regards,<br /><br />
                                <?php echo $user['firstname'] . ' ' . $user['lastname']; ?><br />
                                <?php echo $user['position']; ?><br />
                                <?php  if($user['company'] == 1){echo 'Circus Co. Ltd (Philippine Branch)';}else if($user['company'] == 2){echo 'Tavolozza';}else{echo 'HalloHallo Alliance';} ?>
                              </div><br/>
                            </div>
                         </td>
                    </tr>
                </table>
            </form>
            <div class=" panel-footer">
                <p class=" text-center">
                    <a href="<?php echo base_url(); ?>email/reporttable" class="btn btn-default btn-lg" target="_blank">View Attendance Report</a>&nbsp;
                    <button type="button" class="btn btn-warning btn-lg" onclick="history.back()">Cancel</button>&nbsp;
                    <button id="sendmail" class="btn btn-danger btn-lg">Send</button>
                </p>
            </div>
    </div>
</div>

<script>

   $(document).ready(function(){
      var sendmail = $('#sendmail');
      var errorVal = $('input[name=errorVal]');

      sendmail.on('click', function(){
        var to = $('input[name=to]').val();
        var data = $('.content').html();
        var subj = $('input[name=subject]').val();

        sendmail.attr('disabled', 'disabled');

       if($.trim(to) != ''){
          $.ajax({
            url: ADMIN_URI + 'email/sendmail',
            type: 'post',
            data: {data:data, subj:subj, to:to},
            dataType: 'json',
            beforeSend: function(){
              sendmail.text('Sending...');
            },
            success: function(data){
              if(data.success == 1){
                errorVal.val(0);
                alertify('Mail has been sent to '+to, 'Notification');
              } else {
                errorVal.val(1);
                alertify('Error occurred. Your email was not sent.', 'Error');
                sendmail.removeAttr('disabled', 'disabled');
              }   
            },
            complete: function(){
              sendmail.text('Send');
            }
          }); 
        } else {
          errorVal.val(1);
          alertify('Please enter a valid email', 'Error');
          sendmail.removeAttr('disabled', 'disabled');
        }
      });

      $('#okButton').click(function(){
        if(errorVal.val() == 0){
          window.location.href = ADMIN_URI + "admin/admin_user_cpanel";
        }
      });
      
    });
   

</script>