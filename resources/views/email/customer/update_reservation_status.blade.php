<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
@php
    $dir = app()->getLocale() == 'en' ? 'ltr' : 'rtl';
@endphp
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
    <!--[if gte mso 9]>
<xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG></o:AllowPNG>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]-->

    <style>
        [dir="rtl"] body table,
        [dir="rtl"] body table td,
        [dir="rtl"] body {
            text-align: right;
            direction: rtl;
        }

        body table.es-content_2 .esd-structure table tr,
        body table.es-content_2 .esd-structure table tr td {
            text-align: center;
        }
    </style>

</head>

<body dir="rtl">
    <div class="es-wrapper-color">
        <!--[if gte mso 9]>
   <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
    <v:fill type="tile" color="#eeeeee"></v:fill>
   </v:background>
  <![endif]-->
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="esd-email-paddings" valign="top">
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr></tr>
                                <tr>
                                    <td class="esd-stripe" esd-custom-block-id="7681" align="center">
                                        <table class="es-header-body" style="background-color: #044767;" width="600"
                                            cellspacing="0" cellpadding="0" bgcolor="#044767" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p35t es-p35b es-p35r es-p35l"
                                                        align="left">
                                                        <!--[if mso]></td><td width="20"></td><td width="170" valign="top"><![endif]-->
                                                        <table cellspacing="0" cellpadding="0" align="right">
                                                            <tbody>
                                                                <tr class="es-hidden">
                                                                    <td class="es-m-p20b esd-container-frame"
                                                                        esd-custom-block-id="7704" width="170"
                                                                        align="left">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-spacer es-p5b"
                                                                                        align="center"
                                                                                        style="font-size:0">
                                                                                        <table width="100%"
                                                                                            height="100%"
                                                                                            cellspacing="0"
                                                                                            cellpadding="0"
                                                                                            border="0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td
                                                                                                        style="border-bottom: 1px solid #044767; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;">
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content es-content_2" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" width="600" cellspacing="0" cellpadding="0"
                                            bgcolor="#ffffff" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p40t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530"
                                                                        valign="top" align="center">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-image es-p25t es-p25b es-p35r es-p35l"
                                                                                        align="center"
                                                                                        style="font-size:0">
                                                                                        {{-- <a
                                                                                            target="_blank"
                                                                                            href="https://viewstripo.email/"><img
                                                                                                src="https://tlr.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/67611522142640957.png"
                                                                                                alt
                                                                                                style="display: block; margin: auto;"
                                                                                                width="120"></a> --}}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text"
                                                                                        text-align="center">
                                                                                        <h1> {{ $data['title'] }}</h1>
                                                                                    </td>
                                                                                </tr>
                                                                                @if ($data['body'])
                                                                                    <tr>
                                                                                        <td class="esd-block-text es-p15t es-p20b"
                                                                                            align="center">
                                                                                            <p
                                                                                                style="font-size: 16px; color: #777777;">
                                                                                                {{ $data['body'] }}</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" width="600" cellspacing="0"
                                            cellpadding="0" bgcolor="#ffffff" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p20t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530"
                                                                        valign="top" align="center">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10t es-p10b es-p10r es-p10l"
                                                                                        bgcolor="#eeeeee"
                                                                                        align="left">
                                                                                        <table style="width: 100%;"
                                                                                            class="cke_show_border"
                                                                                            cellspacing="1"
                                                                                            cellpadding="1"
                                                                                            border="0"
                                                                                            align="left">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td width="80%">
                                                                                                        <h4>@lang('site.Reservation Confirmation')
                                                                                                            #</h4>
                                                                                                    </td>
                                                                                                    <td width="20%">
                                                                                                        <h4>{{ $reservation->id }}
                                                                                                        </h4>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-structure es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530"
                                                                        valign="top" align="center">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0" d>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10t es-p10b es-p10r es-p10l"
                                                                                        align="left">
                                                                                        <table style="width: 100%;"
                                                                                            class="cke_show_border"
                                                                                            cellspacing="1"
                                                                                            cellpadding="1"
                                                                                            border="0"
                                                                                            align="left">
                                                                                            @php $child = $reservation->child  @endphp
                                                                                            @if ($child &&  $reservation->school?->is_school_type)
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>@lang('site.Grade')
                                                                                                        </p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{ $child->grade?->title }}
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                @foreach ($reservation->gradeFees as $gradeFees)
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>{{ $gradeFees->title }}</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{ $gradeFees->pivot->price }} {{ appCurrency() }}</p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                @endforeach

                                                                                            </tbody>
                                                                                            @endif


                                                                                            @if ($child &&  $reservation->school?->is_nursery_type)
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>@lang('site.Subscription Type')</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{ $child->subscription_type?->title }} - ({{ $child->subscription_type_price }})
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>@lang('site.Course')</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{ $child->course?->title }}</p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                @foreach ($reservation->nurseryFees as $nurseryFees)
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>{{ $nurseryFees->title }}</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{ $nurseryFees->pivot->price }} {{ appCurrency() }}</p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                @endforeach

                                                                                            </tbody>
                                                                                            @endif


                                                                                            @if (isset($reservation->paidServices))
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>@lang('site.Paid Services')</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p></p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                @foreach ($reservation->paidServices as $paidService)
                                                                                                <tr>
                                                                                                    <td style="padding: 5px 10px 5px 0"
                                                                                                        width="80%"
                                                                                                        align="left">
                                                                                                        <p>{{ $paidService->title }}</p>
                                                                                                    </td>
                                                                                                    <td style="padding: 5px 0"
                                                                                                        width="20%"
                                                                                                        align="left">
                                                                                                        <p>{{ $paidService->pivot->price }} {{ appCurrency() }}</p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                @endforeach

                                                                                            </tbody>
                                                                                            @endif
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-structure es-p10t es-p35r es-p35l" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="530"
                                                                        valign="top" align="center">
                                                                        <table
                                                                            style="border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"
                                                                            width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p15t es-p15b es-p10r es-p10l"
                                                                                        align="left">
                                                                                        <table style="width: 100%;"
                                                                                            class="cke_show_border"
                                                                                            cellspacing="1"
                                                                                            cellpadding="1"
                                                                                            border="0"
                                                                                            align="left">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td width="80%">
                                                                                                        <h4>@lang('site.Total')
                                                                                                        </h4>
                                                                                                    </td>
                                                                                                    <td width="20%">
                                                                                                        <h4>{{ $reservation->total_fees }}
                                                                                                            {{ appCurrency() }}
                                                                                                        </h4>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-structure es-p40t es-p40b es-p35r es-p35l"
                                                        esd-custom-block-id="7796" align="left">
                                                        <!--[if mso]><table width="530" cellpadding="0" cellspacing="0"><tr><td width="255" valign="top"><![endif]-->
                                                        <table class="es-left" cellspacing="0" cellpadding="0"
                                                            align="left">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame es-m-p20b"
                                                                        width="255" align="left">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p15b"
                                                                                        align="left">
                                                                                        <h4>@lang('site.Parent Details')</h4>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p10b"
                                                                                        align="left">
                                                                                        <p>@lang('site.Name') :
                                                                                            {{ $reservation->parent_name }}
                                                                                        </p>
                                                                                        <p>@lang('site.Phone') :
                                                                                            {{ $reservation->parent_phone }}
                                                                                        </p>
                                                                                        <p>@lang('site.Identification Number') :
                                                                                            {{ $reservation->identification_number }}
                                                                                        </p>
                                                                                        <p>@lang('site.Address') :
                                                                                            {{ $reservation->address }}
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--[if mso]></td><td width="20"></td><td width="255" valign="top"><![endif]-->
                                                        <table class="es-right" cellspacing="0" cellpadding="0"
                                                            align="right">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="255"
                                                                        align="left">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p15b"
                                                                                        align="left">
                                                                                        <h4>@lang('site.Student Details')<br></h4>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text"
                                                                                        align="left">
                                                                                        <p>@lang('site.Name') :
                                                                                            {{ $child->child_name }}
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text"
                                                                                        align="left">
                                                                                        <p>@lang('site.Date of birth') :
                                                                                            {{ $child->date_of_birth }}
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text"
                                                                                        align="left">
                                                                                        <p>@lang('site.Gender') :
                                                                                            {{ $child->gender }}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="esd-footer-popover es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" style="background-color: transparent;"
                                            width="600" cellspacing="0" cellpadding="0" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p30t es-p30b es-p20r es-p20l"
                                                        align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="560"
                                                                        valign="top" align="center">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-image es-infoblock made_with"
                                                                                        align="center"
                                                                                        style="font-size:0"><a
                                                                                            target="_blank"><img
                                                                                                src="{{ asset('images/logo/logo.JPG') }}"
                                                                                                alt width="125"></a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
