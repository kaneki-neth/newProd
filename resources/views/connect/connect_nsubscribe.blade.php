<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        /* Base styles for Gmail compatibility */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            line-height: 1.6;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        p {
            margin: 12px 0;
            font-size: 15px;
        }

        /* Rich, Classy, Modern Design */
        .main-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            background-color: #212529;
            padding: 40px 30px;
            text-align: center;
        }

        .logo-line {
            display: block;
            width: 60px;
            height: 2px;
            background-color: #daa520;
            margin: 0 auto 15px;
        }

        .welcome-text {
            font-size: 20px;
            color: #ffffff;
            font-weight: 300;
            margin: 0 0 8px;
            letter-spacing: 2px;
        }

        .logo-text {
            font-size: 38px;
            font-weight: 400;
            color: #ffffff;
            margin: 0;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .content {
            padding: 40px;
            background-color: #ffffff;
        }

        .greeting {
            font-size: 21px;
            font-weight: 500;
            color: #212529;
            margin-bottom: 20px;
        }

        .gold-accent {
            color: #daa520;
            font-weight: 500;
        }

        .benefits-container {
            margin: 30px 0;
            border: 1px solid #e9e9e9;
            padding: 5px;
        }

        .benefits-header {
            background-color: #f8f8f8;
            padding: 15px 20px;
            border-bottom: 1px solid #e9e9e9;
        }

        .benefits-title {
            font-size: 16px;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }

        .benefits-list {
            padding: 20px;
        }

        .benefit-item {
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .benefit-item:last-child {
            border-bottom: none;
        }

        .benefit-marker {
            color: #daa520;
            font-weight: bold;
            padding-right: 10px;
        }

        .about-section {
            margin: 30px 0;
            padding: 25px;
            background-color: #f8f8f8;
            border-left: 3px solid #daa520;
        }

        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9e9e9;
        }

        .team-name {
            color: #212529;
            font-weight: 600;
        }

        .footer {
            padding: 30px;
            text-align: center;
            font-size: 13px;
            color: #ffffff;
            background-color: #212529;
        }

        .address {
            margin-bottom: 20px;
        }

        .footer-line {
            display: block;
            width: 40px;
            height: 2px;
            background-color: #daa520;
            margin: 20px auto;
        }

        .disclaimer {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.1);
            display: inline-block;
            border-radius: 2px;
        }

        .copyright {
            margin-top: 20px;
            opacity: 0.7;
        }

        @media only screen and (max-width: 480px) {

            .content,
            .footer {
                padding: 25px 20px !important;
            }
        }
    </style>
</head>

<body>
    <center>
        <table role="presentation" class="main-container" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <!-- Elegant Dark Header -->
            <tr>
                <td class="header" style="background-color: #212529; padding: 40px 30px; text-align: center;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center">

                                <img src="https://matix.pixzeldigital.app/web/assets/img/matix/logo-white.png" height="70" style="display: block;">
                                <div class="logo-line" style="display: block; width: 60px; height: 2px; background-color: #daa520; margin: 15px auto 0;"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Clean Content Area -->
            <tr>
                <td class="content" style="padding: 40px; background-color: #ffffff;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <p class="greeting" style="font-size: 21px; font-weight: 500; color: #212529; margin-bottom: 20px;">Welcome aboard, <span style="font-weight: bold;">{{ $subscriber->name }}</span>!</p>

                                <p style="text-align: justify; color: #000000;">Thank you for subscribing to the <span class="gold-accent" style="color: #daa520; font-weight: 500;">MATIX UP Cebu</span>! We're thrilled to have you join our community of innovators, researchers, and sustainability enthusiasts.</p>

                                <!-- Benefits Container -->
                                <div class="benefits-container" style="margin: 30px 0; border: 1px solid #e9e9e9; padding: 5px;">
                                    <div class="benefits-header" style="background-color: #f8f8f8; padding: 15px 20px; border-bottom: 1px solid #e9e9e9;">
                                        <p class="benefits-title" style="font-size: 16px; font-weight: 600; color: #212529; margin: 0;">As a subscriber, you'll be the first to receive updates on:</p>
                                    </div>

                                    <div class="benefits-list" style="padding: 20px;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td class="benefit-item" style="padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                                                    <span class="benefit-marker" style="font-weight: bold; padding-right: 10px;">•</span> Latest research in materials science and sustainable design
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="benefit-item" style="padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                                                    <span class="benefit-marker" style="font-weight: bold; padding-right: 10px;">•</span> Additions to our physical and digital materials library
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="benefit-item" style="padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                                                    <span class="benefit-marker" style="font-weight: bold; padding-right: 10px;">•</span> Workshops and training sessions led by international experts
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="benefit-item" style="padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                                                    <span class="benefit-marker" style="font-weight: bold; padding-right: 10px;">•</span> Business incubation opportunities for material-driven enterprises
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="benefit-item" style="padding: 10px 0;">
                                                    <span class="benefit-marker" style="font-weight: bold; padding-right: 10px;">•</span> Case studies on innovative applications of indigenous, bio-based, and recycled materials
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- About Section -->
                                <div class="about-section" style="margin: 30px 0; padding: 25px; background-color: #f8f8f8; border-left: 3px solid #daa520;">
                                    <p style="margin-top: 0; text-align: justify; color: #000000;"><span class="gold-accent" style="color: #daa520; font-weight: 500;">MATIX UP Cebu</span> is a multi-faceted innovation hub that supports material exploration, product development, industry collaboration, and knowledge dissemination. Our center bridges the gap between research, design, and commercialization, making a meaningful impact on sustainability and material innovation in the Philippines.</p>
                                </div>

                                <!-- Signature -->
                                <div class="signature" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9e9e9;">
                                    <p style="text-align: justify; color: #000000;">We look forward to sharing our journey in materials innovation with you!</p>

                                    <p style="text-align: justify; color: #000000;">Best regards,<br>
                                        <span class="team-name" style="color: #212529; font-weight: 600;">The MATIX UP Cebu Team</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Dark Footer -->
            <tr>
                <td class="footer" style="padding: 30px; font-size: 13px; text-align: center;  color: #ffffff; background-color: #212529;">
                    <p class="address" style="margin-bottom: 20px;">
                        University of the Philippines Cebu<br>
                        Gorordo Avenue, Lahug<br>
                        Cebu City 6000
                    </p>

                    <!-- Gold accent line -->
                    <div class="footer-line" style="display: block; width: 40px; height: 2px; background-color: #daa520; margin: 20px auto;"></div>

                    <p class="disclaimer" style="margin: 20px 0; padding: 10px 20px; background-color: rgba(255, 255, 255, 0.1); display: inline-block; border-radius: 2px;">
                        If you did not initiate this subscription, please ignore this message.
                    </p>

                    <p class="copyright" style="margin-top: 20px; opacity: 0.7;">&copy; {{ date('Y') }} MATIX UP Cebu. All rights reserved.</p>
                </td>
            </tr>
        </table>
    </center>
</body>

</html>