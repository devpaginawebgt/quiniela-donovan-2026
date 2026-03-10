<?php

namespace App\Http\Services;

class TermsService
{

    public function getTerms()
    {
        $conditions = "
# Términos y Condiciones de Participación
## Sistema de Quiniela
La participación en el Sistema de Quiniela implica el conocimiento, comprensión y aceptación expresa de los presentes Términos y Condiciones. Toda persona que decida participar declara haber leído y aceptado íntegramente las disposiciones aquí establecidas. En caso de desacuerdo con cualquiera de los términos, deberá abstenerse de participar.
La participación voluntaria constituye aceptación plena y total de las normas que regulan esta actividad.
## 1. Descripción General
El Sistema de Quiniela es una dinámica recreativa dirigida exclusivamente a médicos invitados, que consiste en realizar pronósticos sobre los resultados oficiales de los partidos correspondientes a la Copa Mundial de la FIFA 2026.
Los participantes podrán acceder a la plataforma oficial a través del sitio web:
https://quiniela.placeholder.com
Asimismo, el Sistema de Quiniela contará con una aplicación móvil disponible en App Store y Play Store, desde donde podrá consultarse la misma información, registrar pronósticos y verificar resultados. Tanto la página web como la aplicación reflejarán datos sincronizados.
El objetivo de la actividad es fomentar un espacio de entretenimiento y sana competencia durante el desarrollo del torneo.
El Sistema de Quiniela estará habilitado para participantes en:
- Guatemala
- Honduras
La vigencia de la actividad comprenderá del **11 de junio de 2026 al 19 de julio de 2026**, período oficial de la Copa Mundial de la FIFA 2026.
La inscripción y participación estarán disponibles a partir del **11 de junio de 2026**.
## 2. Mecánica del Sistema
### a) Alcance territorial
El Sistema de Quiniela se desarrollará de manera virtual y estará dirigido a un público seleccionado.
La premiación se realizará por Departamento dentro de cada país, de conformidad con la división territorial administrativa correspondiente. Cada participante competirá dentro del departamento en el cual se encuentre registrado.
### b) Participantes
La participación está limitada exclusivamente a profesionales médicos invitados que ejerzan en Guatemala y Honduras.
No está abierta al público en general.
### c) Inscripción y participación
Los participantes podrán registrarse a partir del **11 de junio de 2026**.
Cada usuario podrá ingresar una predicción por partido.
Los pronósticos podrán registrarse o modificarse hasta **diez minutos antes del inicio de cada encuentro**. Una vez que falten menos de diez (10) minutos para el inicio del partido, el sistema bloqueará automáticamente la opción de ingreso o modificación de pronósticos.
Si el participante no registra una predicción para un partido determinado dentro del plazo establecido, no acumulará puntos en dicho encuentro.
### d) Costo de participación
La participación es **totalmente gratuita** y no requiere pago.
### e) Disponibilidad
El sistema estará disponible **las 24 horas del día** a través del sitio web y la aplicación móvil, sujeto a los plazos de cierre establecidos para cada partido.
### f) Protección de datos
La información proporcionada por los participantes será tratada de forma confidencial y utilizada exclusivamente para la administración, gestión y correcta ejecución del Sistema de Quiniela, conforme a la normativa aplicable en materia de protección de datos personales.
### g) Sistema de puntuación
La asignación de puntos se basará en el resultado oficial del partido al finalizar los **90 minutos reglamentarios**, incluyendo el tiempo añadido por el árbitro. No se considerarán tiempos extra ni tandas de penales.
Los puntos por partido se asignarán de la siguiente manera:
- Acertó ambos marcadores exactos: **3 puntos**
- Acertó el equipo ganador: **2 puntos**
- Predijo empate sin acertar los marcadores exactos: **2 puntos**
- Acertó uno de los marcadores: **1 punto**
Cualquier otro resultado no contemplado no generará puntuación.
El comité organizador podrá designar casos especiales dentro del torneo, en las cuales los partidos seleccionados acumularán **el doble de puntos** conforme al sistema de puntuación establecido. Esta condición será comunicada oportunamente a través de la plataforma antes del inicio del respectivo encuentro.
La tabla de posiciones será verificada y actualizada después de finalizar cada jornada.
## 3. Determinación de Ganadores
### a) Ganadores
Se otorgarán **tres premios por Departamento en cada país**, correspondientes a:
- Primer lugar
- Segundo lugar
- Tercer lugar
Los ganadores serán los participantes que acumulen la mayor cantidad de puntos dentro de su respectivo departamento al finalizar todas las fases del torneo.
### b) Publicación de resultados
Cada participante podrá consultar su puntaje y posición ingresando a la plataforma web o aplicación móvil.
La clasificación final será determinada al concluir el torneo.
### c) Condiciones de los premios
Los premios son **personales e intransferibles**.
No podrán ser canjeados por dinero en efectivo ni sustituidos por otros bienes o servicios.
### d) Notificación
Los ganadores serán contactados a través del correo electrónico registrado durante la inscripción. En dicha comunicación se indicarán las instrucciones para la aceptación y coordinación de la entrega del premio.
En caso de no recibir respuesta dentro del plazo indicado, se entenderá que el participante renuncia al premio, el cual podrá declararse desierto.
### e) Empates
En caso de empate en cualquiera de las posiciones premiadas, el comité organizador podrá establecer un mecanismo de desempate, el cual será informado oportunamente a los participantes involucrados.
### f) Descalificación
Podrá ser descalificado cualquier participante que incumpla los presentes Términos y Condiciones o que realice acciones que comprometan la transparencia, integridad o correcto funcionamiento del Sistema de Quiniela.
## 4. Disposiciones Finales
Cualquier situación no prevista en el presente documento será resuelta por el comité organizador, cuya decisión será definitiva e inapelable.
La participación en el Sistema de Quiniela implica la aceptación total e incondicional de estos Términos y Condiciones, los cuales constituyen un acuerdo vinculante entre el participante y la organización responsable de la actividad.";

        return [
            'version' => '0.1.0',
            'content' => $conditions
        ];
    }
}
