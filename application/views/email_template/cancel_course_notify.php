<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title>
        <?=$title?>
    </title>

    <!--[if mso]>
    <style type="text/css">
      .f-fallback  {
        font-family: Arial, sans-serif;
      }
    </style>
  <![endif]-->
</head>

<body style="margin: 0;">

    <table style="width: 100%; margin: 0; padding: 50px; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; background-color: #F2F4F6;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table style="width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;margin-top: 30px;margin-bottom: 30px;" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Email Body -->
                    <tr>
                        <td style="width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0;-premailer-cellspacing: 0;" width="570" cellpadding="0" cellspacing="0">
                            <table style="width: 570px; margin: 0 auto; padding: 0; -premailer-width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0;
                            background-color: #FFFFFF;" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr style="text-align: center;">
                                    <td>
                                        <a href=""><img src="<?=base_url('frontend/images/')?>dark-logo.png" alt="Code Champs" style="width: 220px;padding-top: 20px;"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 45px;">
                                        <div class="f-fallback">
                                            <h1 style="color: rgb(0, 0, 0); margin-top: 0; font-family: Nunito Sans, Helvetica, Arial, sans-serif;">Dear, {student_name}!</h1>
                                            <p style="font-family: Nunito Sans, Helvetica, Arial, sans-serif;font-size: 15px;">Instructor, {instructor_name} has updated their schedule and due to which your class on {class_date} in '{course_name}' ( {course_level} ) which would be held at {from_time} to {to_time} has been cancelled. You can book this cancelled class on any other day based on instructor's new schedule.</p>
                                        </div>

                                        <div style="margin-top: 3rem; text-align: center;">
                                            <h3 style="font-size: 28px;margin-bottom: 1rem; text-align: center; font-family: Nunito Sans, Helvetica, Arial, sans-serif;">Follow Us</h3>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="<?=base_url('frontend/images/')?>facebook-logo.png" alt="" style="width: 35px;margin-right: 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="<?=base_url('frontend/images/')?>twitter-icon.png" alt="" style="width: 35px;margin-right: 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="<?=base_url('frontend/images/')?>instagram-icon.png" alt="" style="width: 35px;margin-right: 5px;">
                                            </a>
                                            <a href="#" style="text-decoration: none;">
                                                <img src="<?=base_url('frontend/images/')?>twitter-icon.png" alt="" style="width: 35px;margin-right: 5px;">
                                            </a>
                                        </div>
                                        <p style="font-size: 15px;padding-top: 30px;text-align: center;font-family: Nunito Sans, Helvetica, Arial, sans-serif;;color: #000;line-height: 25px;">
                                            {business_address}<br> <strong>Call Us:</strong> {business_phone} <br> <strong>Email Us:</strong> {business_email}
                                        </p>

                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>