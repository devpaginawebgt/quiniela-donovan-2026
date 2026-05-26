<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $customSubject ?? 'System Notification' }}</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; color:#FFFFFF;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0; background:#101820;">
    <tr>
      <td align="center">

        <table width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background:#1F2A44; border-radius:10px; overflow:hidden;">

          <tr>
            <td align="center" style="padding:30px 20px 10px 20px;">
              <img
                src="{{ rtrim(config('app.url'), '/') . '/images/logos/logo-white.png' }}"
                alt="Logo"
                width="220"
                style="display:block; max-width:220px; height:auto;"
              >
            </td>
          </tr>

          <tr>
            <td style="padding:20px 30px 30px 30px; color:#FFFFFF; font-size:15px; line-height:1.6;">
              {!! nl2br(e($body)) !!}
            </td>
          </tr>

          <tr>
            <td align="center" style="padding:15px 20px; background:#101820; color:#D9D9D6; font-size:12px;">
              Quiniela Donovan · Notificación del sistema
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>
