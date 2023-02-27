<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="margin:0px;">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
<div style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;color:#74787e;height:100%;line-height:1.4;margin:0;width:100%!important;word-break:break-word">


  <table class="wrapper" width="100%" cellpadding="12" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%">
    <tbody><tr>
      <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
        <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%">
          <tbody>
            {{-- header --}}
            <tr>
              <td class="header" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center">
                <a href="{{ sc_route('home') }}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" target="_blank">
                  {{ config('app.name') }}
                </a>
              </td>
            </tr>
            {{-- end header --}}

          {{-- main --}}
          <tr>
            <td class="body" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
              <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">

                <tbody>
                  <tr>
                      <td class="content-cell" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                        @yield('main')
                        <p style="box-sizing:border-box;font-family:Avenir,Helvetica,sans-serif;font-size:14px;line-height:1.5em;margin-top:0;text-align:left">
                          {{ sc_language_render('email.msg_goodbye') }}<br>
                          {{ config('app.name') }}
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
                </td>
              </tr>
  {{-- end main --}}


  {{-- footer --}}
              <tr>
                <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                  <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0 auto;padding:0;text-align:center;width:570px">
                    <tbody><tr>
                      <td class="content-cell" align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;line-height:1.5em;margin-top:0;color:#aeaeae;font-size:12px;text-align:center">&copy;{{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
  {{-- end footer --}}
            </tbody></table>
          </td>
        </tr>
      </tbody></table>

    </div>


    </body>
</html>
