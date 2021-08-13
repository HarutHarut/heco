<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>buycycle</title>
    <style type="text/css">
        body {
            width: 100%;

            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        a{
            color: #80be70;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        .im{
            color: #000000!important;
        }
    </style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="100%" valign="top" style="padding-top:20px;">
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:0 auto; width:100%; max-width: 600px;border: solid 1px #e0e0e0;">
                <tr>
                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                        <table width="100%" style="border-spacing:0;">
                            <tbody>
                            <tr>
                                <td height="69" style="width: 100px; border-bottom: solid 6px #80be70; background-color:#ffffff;padding-top:10px;padding-bottom:5px;padding-right:20px;padding-left:40px;">
                                    <a href="/" valign="middle" style="text-decoration:none; color:#000000; display: inline-block;">
                                        <img src="https://res.cloudinary.com/chess/image/upload/v1621839166/logo-buycycle_jdd726.jpg" title="" alt="buycycle" width="236">
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td class="bg" height="300" style="vertical-align: top;padding:40px 10px 0 40px;background-color: #3c3c3b;" valign="top">

                        <table border="0" cellpadding="0" cellspacing="0" align="center" style="margin-left: 0;">
                          @yield('content')
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background-color:#ffffff; padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                        <table style="border-spacing:0;color:#000000; text-align: right; width: 100%;">
                            <tbody>
                            <tr>
                                <td align="right" style=" color:#000000; font-size:16px;padding-top:0;padding-bottom:0;padding-right:20px;padding-left:20px;width:100%;">
                                    <p style="font-size:12px;Margin:0;Margin-bottom:10px; margin-top:12px;">
                                        {{__('Copyright') . ' ' . date('Y') . ' ' . 'Buycycle. ' .  __('All rights reserved')}}.
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

