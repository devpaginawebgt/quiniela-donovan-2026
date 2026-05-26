<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenido al DonoMundial 2026</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; color:#FFFFFF;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
    <tr>
      <td align="center">

        <!-- Contenedor principal -->
        <table width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background:#1F2A44; border-radius:10px; overflow:hidden;">

          <!-- Logo -->
          <tr>
            <td align="center" style="padding:30px 20px 10px 20px;">
              <img 
                src="{{ rtrim(config('app.url'), '/') . '/images/logos/logo-liga.png' }}"
                alt="Logo"
                width="140"
                style="display:block; max-width:140px; height:auto;"
              >
            </td>
          </tr>

          <!-- Bienvenida -->
          <tr>
            <td style="padding:20px 30px;">
              <h2 style="margin:0; font-size:22px; color:#FFDD00;">
                ¡Bienvenido{{ isset($user->nombres) && $user->nombres ? ', ' . $user->nombres : '' }}!
              </h2>

              <p style="margin:15px 0 0 0; font-size:15px; line-height:1.6; color:#FFFFFF;">
                Nos alegra tenerte en el DonoMundial. Prepárate para disfrutar del torneo en un espacio de entretenimiento y sana competencia.
              </p>
            </td>
          </tr>

          <!-- Acceso -->
          <tr>
            <td style="padding:0 30px 20px 30px;">
              <p style="margin:0 0 10px 0; font-size:15px;">
                Puedes acceder a la plataforma desde el siguiente enlace, o escanea el código QR
              </p>

              <p style="margin:0; text-align:center;">
                <a href="https://quiniela-donovan.plan-paciente.com/inicio"
                   style="color:#FFDD00; text-decoration:none; font-weight:bold;">
                    {{ rtrim(config('app.url'), '/') }}
                </a>
              </p>
            </td>
          </tr>

          <!-- QR -->
          <tr>
            <td align="center" style="padding:20px;">
              <img
                src="{{ rtrim(config('app.url'), '/') . '/images/decoracion/qr-code-donovan.png' }}"
                alt="Código QR"
                width="200"
                style="display:block; width:180px; max-width:100%; height:auto; padding:5px;"
              >              
            </td>
          </tr>

          <tr>
            <td style="padding:20px 30px;">
                
                <p style="margin:0 0 12px 0; font-size:14px; line-height:1.6; color:#FFFFFF;">
                También puedes descargar nuestra aplicación móvil desde la Play Store y vivir la experiencia desde tu teléfono móvil.
                </p>

                <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
                    <tr>
                        <td style="padding:0 8px;" align="center" valign="middle">
                            <a
                                href="https://play.google.com/store/apps/details?id=com.donovanwerke.pronosticos"
                                style="text-decoration:none;"
                                target="_blank"
                            >
                                <img src="{{ rtrim(config('app.url'), '/') . '/images/decoracion/play_store.png' }}"
                                    alt="Descargar en Google Play" width="147" height="46"
                                    style="display:block; border:0; outline:none; width:147px; height:46px;">
                            </a>
                        </td>
                        <td style="padding:0 8px;" align="center" valign="middle">
                            <a href="https://apps.apple.com/app/id6761441900" style="text-decoration:none;" target="_blank">
                                <img src="{{ rtrim(config('app.url'), '/') . '/images/decoracion/app_store.png' }}"
                                    alt="Descargar en App Store" width="133" height="46"
                                    style="display:block; border:0; outline:none; width:133px; height:46px;">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
          </tr>

          <!-- Recordatorios -->
          <tr>
            <td style="padding:20px 30px;">
              <h3 style="margin:0 0 15px 0; font-size:16px; color:#FFDD00;">
                Información importante
              </h3>

              <ul style="margin:0; padding-left:18px; font-size:14px; line-height:1.6; color:#FFFFFF;">
                <li style="margin-bottom:8px;">
                  El objetivo es fomentar un espacio de entretenimiento y sana competencia durante el torneo.
                </li>
                <li style="margin-bottom:8px;">
                  La premiación se realizará por Departamento dentro de cada país, según la división territorial administrativa correspondiente.
                </li>
                <li style="margin-bottom:8px;">
                  Cada usuario podrá ingresar una predicción por partido.
                </li>
                <li style="margin-bottom:8px;">
                  Los pronósticos podrán registrarse o modificarse hasta diez minutos antes del inicio de cada encuentro.
                </li>
                <li style="margin-bottom:8px;">
                  Si no registras una predicción dentro del plazo, no acumularás puntos en ese partido.
                </li>
              </ul>
            </td>
          </tr>

          <!-- Sistema de puntos -->
          <tr>
            <td style="padding:0 30px 25px 30px;">
              <h3 style="margin:0 0 15px 0; font-size:16px; color:#FFDD00;">
                Sistema de puntuación
              </h3>

              <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:14px; color:#FFFFFF;">
                <tr>
                  <td style="padding:8px 0; border-bottom:1px solid #a1a1aa;">Acertó ambos marcadores exactos</td>
                  <td align="right" style="padding:8px 0; border-bottom:1px solid #a1a1aa;"><strong>3 pts</strong></td>
                </tr>
                <tr>
                  <td style="padding:8px 0; border-bottom:1px solid #a1a1aa;">Acertó el equipo ganador</td>
                  <td align="right" style="padding:8px 0; border-bottom:1px solid #a1a1aa;"><strong>2 pts</strong></td>
                </tr>
                <tr>
                  <td style="padding:8px 0; border-bottom:1px solid #a1a1aa;">Predijo empate sin marcador exacto</td>
                  <td align="right" style="padding:8px 0; border-bottom:1px solid #a1a1aa;"><strong>2 pts</strong></td>
                </tr>
                <tr>
                  <td style="padding:8px 0; border-bottom:1px solid #a1a1aa;">Acertó uno de los marcadores</td>
                  <td align="right" style="padding:8px 0; border-bottom:1px solid #a1a1aa;"><strong>1 pt</strong></td>
                </tr>
              </table>

              <p style="margin:15px 0 0 0; font-size:14px; line-height:1.6;">
                Podrás consultar tu puntaje y posición ingresando a la plataforma web o aplicación móvil.
              </p>
            </td>
          </tr>

          <tr>
            <td style="padding:20px 30px 10px 30px;">
                <p style="margin:0; font-size:14px; line-height:1.7; color:#FFFFFF;">
                Te deseamos una experiencia excepcional durante todo el torneo. 
                Disfruta cada encuentro, participa con entusiasmo y que tus pronósticos 
                te lleven a lo más alto de la competencia.
                </p>

                <p style="margin:12px 0 0 0; font-size:14px; line-height:1.7; color:#FFDD00; font-weight:bold;">
                ¡Que gane el mejor! 🏆
                </p>
            </td>
          </tr>

          <tr>
            <td style="padding:20px 30px 10px 30px;">
                <p style="margin:0; font-size:14px; line-height:1.7; color:#FFFFFF;">
                    Attentamente,
                </p>

                <p style="margin:0; font-size:14px; line-height:1.7; color:#FFFFFF;">
                    {{ config('app.name') }}
                </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:15px 30px; font-size:12px; text-align:center; color:#FFFFFF;">
              © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>