<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body style="margin: 0; padding: 0; font-family: 'Roboto', sans-serif; background-color: #ffffff;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff;">
                    <!-- Header -->
                    <tr>
                        <td bgcolor="#FFA01C" style="padding: 20px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td width="70%">
                                        <img src="https://matix.pixzeldigital.app/web/assets/img/mainlogo.png" height="50" style="display: block;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- User Info -->
                    <tr>
                        <td style="padding: 20px 30px; border-bottom: 1px solid #eeeeee;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td width="60" valign="top">
                                        <img src="https://matix.pixzeldigital.app/web/assets/img/icon-user.png" width="60" height="60" style="display:block;">
                                    </td>
                                    <td style="padding-left: 20px;">
                                        <h3 style="margin: 0 0 5px 0; font-size: 18px; font-weight: bold;">{{ $connect->name }}</h3>
                                        <a href="mailto:{{ $connect->email }}" style="margin: 0; color: #000000; font-size: 12px; text-decoration: none;">{{ $connect->email }}</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Message Content -->
                    <tr>
                        <td style="padding: 20px 30px;">
                            <p style="text-align: justify; line-height: 1.6; margin: 0 0 20px 0;">{{ $connect->message }}</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="text-align: justify; padding: 15px 30px; border-top: 1px solid #eeeeee; color: #666666; font-size: 11px;">
                            <p style="margin: 0;">This message was sent from the FabLab UP Cebu website. Please note that this is an automated response. Do not reply to this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>