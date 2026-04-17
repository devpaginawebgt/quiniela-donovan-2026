<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipos = [

            // ======================
            // GRUPO A (1)
            // ======================
            [
                'nombre' => 'México',
                'codigo_iso' => 'MX',
                'imagen' => '/images/selecciones/mx.jpg',
                'descripcion' => 'La selección nacional de fútbol de México es una de las más destacadas de la Concacaf y ha participado en múltiples Copas del Mundo desde 1930. Ha alcanzado los cuartos de final en los Mundiales de 1970 y 1986, ambos disputados como país anfitrión. México ha conquistado varias Copas Oro de la Concacaf y es reconocido por su intensa rivalidad con Estados Unidos. A lo largo de su historia ha contado con figuras emblemáticas como Hugo Sánchez, Cuauhtémoc Blanco, Rafael Márquez, Jared Borgetti y Guillermo Ochoa.',
                'grupo' => 1,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Sudáfrica',
                'codigo_iso' => 'ZA',
                'imagen' => '/images/selecciones/za.jpg',
                'descripcion' => 'La selección nacional de fútbol de Sudáfrica, conocida como "Bafana Bafana", representa al país en competiciones internacionales desde su readmisión en 1992 tras el fin del apartheid. Su mayor logro internacional fue la conquista de la Copa Africana de Naciones en 1996. En 2010 hizo historia al convertirse en la primera nación africana en organizar una Copa Mundial de la FIFA. Aunque no logró avanzar a la segunda fase, dejó una huella importante como anfitriona del torneo.',
                'grupo' => 1,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Corea',
                'codigo_iso' => 'KR',
                'imagen' => '/images/selecciones/kr.jpg',
                'descripcion' => 'La selección nacional de fútbol de la República de Corea, conocida comúnmente como Corea del Sur, es una de las potencias del fútbol asiático. Ha participado en múltiples Copas del Mundo y alcanzó su mejor resultado en 2002, cuando fue coanfitriona del torneo y logró un histórico cuarto lugar. Es reconocida por su intensidad física, disciplina táctica y velocidad de juego. A lo largo de su historia ha contado con figuras destacadas como Park Ji-sung, Hong Myung-bo, Son Heung-min y Cha Bum-kun.',
                'grupo' => 1,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'R. Checa',
                'codigo_iso' => 'CZ',
                'imagen' => '/images/selecciones/cz.png',
                'descripcion' => 'La selección nacional de fútbol de Chequia, anteriormente conocida como República Checa, es una de las más competitivas de Europa Central. Como Checoslovaquia conquistó la Eurocopa en 1976 y fue subcampeona del mundo en 1934 y 1962. Ya como República Checa alcanzó la final de la Eurocopa en 1996 y las semifinales en 2004. Es reconocida por su solidez táctica, tradición futbolística y figuras destacadas como Pavel Nedvěd, Petr Čech y Karel Poborský.',
                'grupo' => 1,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO B (2)
            // ======================
            [
                'nombre' => 'Canadá',
                'codigo_iso' => 'CA',
                'imagen' => '/images/selecciones/ca.jpg',
                'descripcion' => 'La selección nacional de fútbol de Canadá ha experimentado un notable crecimiento en la última década, consolidándose como una de las selecciones emergentes de la Concacaf. Clasificó a la Copa Mundial de la FIFA 2022 tras una destacada fase eliminatoria y será coanfitriona del Mundial 2026 junto a Estados Unidos y México. Su mayor logro continental ha sido la conquista de la Copa Oro en 2000. En la actualidad cuenta con una generación talentosa encabezada por jugadores como Alphonso Davies y Jonathan David.',
                'grupo' => 2,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Bosnia',
                'codigo_iso' => 'BA',
                'imagen' => '/images/selecciones/ba.png',
                'descripcion' => 'La selección nacional de fútbol de Bosnia y Herzegovina compite de forma independiente desde 1996 tras la disolución de Yugoslavia. Logró su primera clasificación a una Copa Mundial de la FIFA en Brasil 2014, marcando un hito histórico para el país. Es reconocida por su fortaleza competitiva, intensidad de juego y por haber contado con futbolistas destacados como Edin Džeko, Miralem Pjanić y Asmir Begović, quienes han brillado en las principales ligas europeas.',
                'grupo' => 2,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Catar',
                'codigo_iso' => 'QA',
                'imagen' => '/images/selecciones/qa.jpg',
                'descripcion' => 'La selección nacional de fútbol de Catar ha crecido de manera significativa en la última década gracias a un ambicioso proyecto de desarrollo deportivo. Su mayor logro internacional fue la conquista de la Copa Asiática en 2019, donde sorprendió al continente con un fútbol ofensivo y disciplinado. En 2022 hizo historia al convertirse en el primer país árabe en organizar una Copa Mundial de la FIFA. Aunque su tradición futbolística es reciente en comparación con otras potencias, Catar se ha consolidado como una selección competitiva en Asia.',
                'grupo' => 2,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Suiza',
                'codigo_iso' => 'CH',
                'imagen' => '/images/selecciones/ch.jpg',
                'descripcion' => 'La selección nacional de fútbol de Suiza es una de las más constantes de Europa en torneos internacionales. Ha participado en múltiples Copas del Mundo, alcanzando los cuartos de final en 1934, 1938 y 1954. En la Eurocopa ha logrado destacadas actuaciones recientes, incluyendo los cuartos de final en 2020. Es reconocida por su organización táctica, solidez defensiva y equilibrio colectivo. A lo largo de su historia ha contado con jugadores destacados como Xherdan Shaqiri, Granit Xhaka y Stéphane Chapuisat.',
                'grupo' => 2,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO C (3)
            // ======================
            [
                'nombre' => 'Brasil',
                'codigo_iso' => 'BR',
                'imagen' => '/images/selecciones/br.jpg',
                'descripcion' => 'La selección nacional de fútbol de Brasil es la más exitosa en la historia de la Copa Mundial de la FIFA, con cinco títulos obtenidos en 1958, 1962, 1970, 1994 y 2002. Es reconocida mundialmente por su estilo de juego ofensivo y técnico, conocido como "jogo bonito". A lo largo de su historia ha contado con futbolistas legendarios como Pelé, Zico, Romário, Ronaldo, Ronaldinho y Neymar. Además, Brasil es la única selección que ha participado en todas las ediciones del Mundial desde 1930.',
                'grupo' => 3,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Marruecos',
                'codigo_iso' => 'MA',
                'imagen' => '/images/selecciones/ma.jpg',
                'descripcion' => 'La selección nacional de fútbol de Marruecos, conocida como "Los Leones del Atlas", es una de las más destacadas del continente africano. En la Copa Mundial de la FIFA 2022 hizo historia al convertirse en la primera selección africana en alcanzar las semifinales del torneo, logrando un histórico cuarto lugar. Ha participado en varias ediciones del Mundial y ha ganado la Copa Africana de Naciones en 1976. Marruecos es reconocida por su solidez defensiva, intensidad competitiva y por figuras recientes como Achraf Hakimi, Hakim Ziyech y Yassine Bounou.',
                'grupo' => 3,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Haití',
                'codigo_iso' => 'HT',
                'imagen' => '/images/selecciones/ht.jpg',
                'descripcion' => 'La selección nacional de fútbol de Haití es una de las representativas históricas del Caribe dentro de la Concacaf. Su participación más destacada en la Copa Mundial de la FIFA fue en Alemania 1974, siendo hasta la fecha su única aparición en el torneo. Haití también ha tenido actuaciones importantes en la Copa Oro y logró conquistar el Campeonato de la Concacaf en 1973. A pesar de los desafíos estructurales y deportivos, la selección haitiana mantiene un papel relevante en el fútbol caribeño y continúa en proceso de desarrollo.',
                'grupo' => 3,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Escocia',
                'codigo_iso' => 'GB-SCT',
                'imagen' => '/images/selecciones/gb-sct.jpg',
                'descripcion' => 'La selección nacional de fútbol de Escocia es una de las más antiguas del mundo y disputó el primer partido internacional oficial en 1872 frente a Inglaterra. Ha participado en varias Copas del Mundo, principalmente entre las décadas de 1970 y 1990, aunque nunca ha superado la fase de grupos. Escocia también ha competido en distintas ediciones de la Eurocopa y mantiene una histórica rivalidad con Inglaterra dentro del Reino Unido. Es reconocida por su tradición futbolística, el apoyo apasionado de su afición y figuras destacadas como Kenny Dalglish, Denis Law y Andrew Robertson.',
                'grupo' => 3,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO D (4)
            // ======================
            [
                'nombre' => 'USA',
                'codigo_iso' => 'US',
                'imagen' => '/images/selecciones/us.jpg',
                'descripcion' => 'La selección nacional de fútbol de Estados Unidos es una de las principales potencias de la Concacaf. Ha participado en múltiples Copas del Mundo, logrando como mejor resultado las semifinales en 1930 y los cuartos de final en 2002. En los últimos años ha experimentado un crecimiento sostenido gracias a una nueva generación de futbolistas que compiten en las principales ligas europeas. Será uno de los países anfitriones de la Copa Mundial de la FIFA 2026 junto a México y Canadá, consolidando su papel como potencia emergente en el fútbol internacional.',
                'grupo' => 4,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Paraguay',
                'codigo_iso' => 'PY',
                'imagen' => '/images/selecciones/py.jpg',
                'descripcion' => 'La selección nacional de fútbol de Paraguay es una de las históricas competidoras de la Conmebol. Ha participado en varias Copas del Mundo, alcanzando los cuartos de final en Sudáfrica 2010, su mejor actuación en el torneo. También ha sido subcampeona de la Copa América y es reconocida por su estilo de juego combativo y sólida organización defensiva. A lo largo de su historia ha contado con figuras destacadas como José Luis Chilavert, Roque Santa Cruz y Salvador Cabañas.',
                'grupo' => 4,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Australia',
                'codigo_iso' => 'AU',
                'imagen' => '/images/selecciones/au.jpg',
                'descripcion' => 'La selección nacional de fútbol de Australia representa al país en competiciones internacionales y está afiliada a la Confederación Asiática de Fútbol (AFC) desde 2006, tras dejar la OFC. Ha participado en varias Copas del Mundo y logró alcanzar los octavos de final en Alemania 2006 y nuevamente en Catar 2022. Su mayor logro continental fue la conquista de la Copa Asiática en 2015, torneo que organizó como anfitriona. Es conocida por su fortaleza física, disciplina táctica y competitividad internacional.',
                'grupo' => 4,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Turquía',
                'codigo_iso' => 'TR',
                'imagen' => '/images/selecciones/tr.jpg',
                'descripcion' => 'La selección nacional de fútbol de Turquía ha tenido actuaciones destacadas en competiciones internacionales, siendo su mayor logro el tercer lugar en la Copa Mundial de la FIFA 2002. También alcanzó las semifinales de la Eurocopa en 2008, consolidándose como una selección competitiva en el ámbito europeo. Es reconocida por su intensidad de juego, carácter combativo y el fuerte apoyo de su afición. A lo largo de su historia ha contado con figuras importantes como Hakan Şükür, Rüştü Reçber y Arda Turan.',
                'grupo' => 4,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO E (5)
            // ======================
            [
                'nombre' => 'Alemania',
                'codigo_iso' => 'DE',
                'imagen' => '/images/selecciones/de.jpg',
                'descripcion' => 'La selección nacional de fútbol de Alemania es una de las más exitosas y tradicionales del mundo. Ha conquistado cuatro Copas Mundiales de la FIFA en 1954, 1974, 1990 y 2014, además de tres Eurocopas. Es reconocida históricamente por su disciplina táctica, fortaleza mental y capacidad competitiva en torneos internacionales. A lo largo de su historia ha contado con figuras legendarias como Franz Beckenbauer, Gerd Müller, Lothar Matthäus, Miroslav Klose y Philipp Lahm. Alemania es considerada una de las grandes potencias del fútbol mundial.',
                'grupo' => 5,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Curazao',
                'codigo_iso' => 'CW',
                'imagen' => '/images/selecciones/cw.jpg',
                'descripcion' => 'La selección nacional de fútbol de Curazao representa al territorio caribeño en competiciones internacionales y forma parte de la Concacaf. Tras la disolución de las Antillas Neerlandesas en 2010, Curazao asumió su lugar en el ámbito futbolístico internacional. En los últimos años ha mostrado un crecimiento competitivo, clasificando a la Copa Oro y desarrollando jugadores con experiencia en ligas europeas. Es considerada una de las selecciones caribeñas con mayor proyección dentro de la región.',
                'grupo' => 5,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Costa de Marfil',
                'codigo_iso' => 'CI',
                'imagen' => '/images/selecciones/ci.jpg',
                'descripcion' => 'La selección nacional de fútbol de Costa de Marfil es una de las potencias tradicionales del continente africano. Ha participado en varias Copas del Mundo y ha conquistado la Copa Africana de Naciones en 1992 y 2015. Durante la llamada "generación dorada" contó con futbolistas de talla mundial como Didier Drogba, Yaya Touré y Kolo Touré. Es reconocida por su potencia física, calidad técnica y competitividad en torneos internacionales.',
                'grupo' => 5,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Ecuador',
                'codigo_iso' => 'EC',
                'imagen' => '/images/selecciones/ec.jpg',
                'descripcion' => 'La selección nacional de fútbol de Ecuador es una de las competidoras habituales de la Conmebol y ha participado en varias Copas del Mundo, alcanzando los octavos de final en Alemania 2006 como su mejor actuación histórica. Es conocida por su intensidad física, velocidad por las bandas y fortaleza como local en la altitud de Quito. En los últimos años ha desarrollado una generación joven y talentosa que compite en las principales ligas europeas.',
                'grupo' => 5,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO F (6)
            // ======================
            [
                'nombre' => 'Países Bajos',
                'codigo_iso' => 'NL',
                'imagen' => '/images/selecciones/nl.jpg',
                'descripcion' => 'La selección nacional de fútbol de los Países Bajos es una de las más históricas de Europa. Ha sido subcampeona del mundo en tres ocasiones (1974, 1978 y 2010) y es reconocida por el desarrollo del "fútbol total", estilo que revolucionó el juego en la década de 1970 con figuras como Johan Cruyff. También conquistó la Eurocopa en 1988. A lo largo de su historia ha contado con futbolistas destacados como Marco van Basten, Ruud Gullit, Dennis Bergkamp, Arjen Robben y Virgil van Dijk.',
                'grupo' => 6,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Japón',
                'codigo_iso' => 'JP',
                'imagen' => '/images/selecciones/jp.jpg',
                'descripcion' => 'La selección nacional de fútbol de Japón es una de las principales potencias de Asia. Ha participado regularmente en la Copa Mundial de la FIFA desde 1998 y ha alcanzado los octavos de final en varias ediciones. Fue coanfitriona del Mundial 2002 junto a Corea del Sur. Japón ha conquistado múltiples Copas Asiáticas y es reconocida por su disciplina táctica, velocidad y desarrollo técnico. En las últimas décadas ha producido futbolistas destacados que compiten en las principales ligas europeas.',
                'grupo' => 6,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Suecia',
                'codigo_iso' => 'SE',
                'imagen' => '/images/selecciones/se.jpg',
                'descripcion' => 'La selección nacional de fútbol de Suecia es una de las históricas del continente europeo. Su mayor logro en la Copa Mundial de la FIFA fue el subcampeonato en 1958, torneo que organizó como anfitriona. También alcanzó el tercer lugar en 1950 y 1994. Es reconocida por su fortaleza física, orden táctico y tradición competitiva. A lo largo de su historia ha contado con figuras destacadas como Gunnar Nordahl, Henrik Larsson y Zlatan Ibrahimović.',
                'grupo' => 6,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Túnez',
                'codigo_iso' => 'TN',
                'imagen' => '/images/selecciones/tn.jpg',
                'descripcion' => 'La selección nacional de fútbol de Túnez es una de las representantes habituales del continente africano en competiciones internacionales. Ha participado en varias Copas del Mundo desde su debut en 1978, cuando logró la primera victoria de una selección africana en el torneo. También ha conquistado la Copa Africana de Naciones en 2004 como anfitriona. Es reconocida por su disciplina táctica, intensidad competitiva y regularidad en las eliminatorias africanas.',
                'grupo' => 6,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO G (7)
            // ======================
            [
                'nombre' => 'Bélgica',
                'codigo_iso' => 'BE',
                'imagen' => '/images/selecciones/be.jpg',
                'descripcion' => 'La selección nacional de fútbol de Bélgica ha sido una de las protagonistas del fútbol europeo en la última década gracias a su denominada "generación dorada". Alcanzó el tercer lugar en la Copa Mundial de la FIFA 2018, su mejor resultado histórico, y ha sido habitual protagonista en Eurocopas y Mundiales. Es reconocida por su talento ofensivo, solidez colectiva y jugadores de élite que han competido en las principales ligas europeas, como Kevin De Bruyne, Eden Hazard y Romelu Lukaku.',
                'grupo' => 7,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Egipto',
                'codigo_iso' => 'EG',
                'imagen' => '/images/selecciones/eg.jpg',
                'descripcion' => 'La selección nacional de fútbol de Egipto es una de las más exitosas del continente africano. Ha conquistado la Copa Africana de Naciones en múltiples ocasiones, siendo la selección con más títulos en la historia del torneo. Participó en la Copa Mundial de la FIFA en 1934, 1990 y 2018. Es reconocida por su tradición futbolística en el norte de África y por figuras destacadas como Mohamed Salah, uno de los jugadores africanos más influyentes de la actualidad.',
                'grupo' => 7,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Irán',
                'codigo_iso' => 'IR',
                'imagen' => '/images/selecciones/ir.jpg',
                'descripcion' => 'La selección nacional de fútbol de Irán es una de las potencias tradicionales del continente asiático. Ha participado en múltiples Copas del Mundo desde su debut en 1978 y ha sido campeona de la Copa Asiática en tres ocasiones (1968, 1972 y 1976). Es reconocida por su solidez defensiva, disciplina táctica y regularidad en las eliminatorias asiáticas. En las últimas décadas ha contado con futbolistas destacados que compiten en ligas internacionales.',
                'grupo' => 7,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Nueva Zelanda',
                'codigo_iso' => 'NZ',
                'imagen' => '/images/selecciones/nz.jpg',
                'descripcion' => 'La selección nacional de fútbol de Nueva Zelanda es la principal potencia de la Confederación de Fútbol de Oceanía (OFC). Ha participado en la Copa Mundial de la FIFA en 1982 y 2010, destacando especialmente en Sudáfrica 2010, donde terminó invicta en la fase de grupos. Es reconocida por su fortaleza física y dominio regional en Oceanía, además de su constante presencia en las competiciones continentales.',
                'grupo' => 7,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO H (8)
            // ======================
            [
                'nombre' => 'España',
                'codigo_iso' => 'ES',
                'imagen' => '/images/selecciones/es.jpg',
                'descripcion' => 'La selección nacional de fútbol de España es una de las potencias históricas del fútbol mundial. Conquistó la Copa Mundial de la FIFA en 2010 y logró un histórico bicampeonato de Europa en 2008 y 2012, consolidando una era dorada basada en el estilo de juego conocido como "tiki-taka". A lo largo de su historia ha contado con futbolistas destacados como Xavi Hernández, Andrés Iniesta, Iker Casillas y Sergio Ramos. España es reconocida por su dominio del balón, precisión técnica y desarrollo constante de talento.',
                'grupo' => 8,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Cabo Verde',
                'codigo_iso' => 'CV',
                'imagen' => '/images/selecciones/cv.jpg',
                'descripcion' => 'La selección nacional de fútbol de Cabo Verde representa al país africano insular en competiciones internacionales y forma parte de la Confederación Africana de Fútbol (CAF). En las últimas décadas ha mostrado un crecimiento sostenido, clasificando en varias ocasiones a la Copa Africana de Naciones. Es considerada una selección emergente dentro del continente, con jugadores que compiten en ligas europeas y un estilo de juego dinámico y competitivo.',
                'grupo' => 8,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Arabia Saudí',
                'codigo_iso' => 'SA',
                'imagen' => '/images/selecciones/sa.jpg',
                'descripcion' => 'La selección nacional de fútbol de Arabia Saudí es una de las más destacadas del continente asiático. Ha participado en múltiples Copas del Mundo desde su debut en 1994, torneo en el que alcanzó los octavos de final como su mejor actuación histórica. También ha conquistado la Copa Asiática en varias ocasiones. Es reconocida por su velocidad, técnica individual y regularidad en las eliminatorias asiáticas.',
                'grupo' => 8,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Uruguay',
                'codigo_iso' => 'UY',
                'imagen' => '/images/selecciones/uy.jpg',
                'descripcion' => 'La selección nacional de fútbol de Uruguay es una de las más históricas y exitosas del mundo. Fue campeona de la Copa Mundial de la FIFA en 1930 y 1950, además de conquistar múltiples Copas América. A pesar de su población reducida, Uruguay ha sido tradicionalmente una potencia sudamericana gracias a su garra competitiva, conocida como "la garra charrúa". A lo largo de su historia ha contado con figuras emblemáticas como Obdulio Varela, Enzo Francescoli, Diego Forlán, Luis Suárez y Edinson Cavani.',
                'grupo' => 8,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO I (9)
            // ======================
            [
                'nombre' => 'Francia',
                'codigo_iso' => 'FR',
                'imagen' => '/images/selecciones/fr.jpg',
                'descripcion' => 'La selección nacional de fútbol de Francia es una de las grandes potencias del fútbol mundial. Ha conquistado la Copa Mundial de la FIFA en 1998 y 2018, y fue subcampeona en 2006 y 2022. Además, ha ganado la Eurocopa en 1984 y 2000. Francia es reconocida por su talento individual, solidez colectiva y la capacidad de producir generaciones competitivas de manera constante. A lo largo de su historia ha contado con figuras legendarias como Zinedine Zidane, Thierry Henry, Michel Platini y Kylian Mbappé.',
                'grupo' => 9,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Senegal',
                'codigo_iso' => 'SN',
                'imagen' => '/images/selecciones/sn.jpg',
                'descripcion' => 'La selección nacional de fútbol de Senegal es una de las más destacadas del continente africano en las últimas décadas. Alcanzó los cuartos de final en la Copa Mundial de la FIFA 2002 en su primera participación, sorprendiendo al mundo al eliminar a Francia en el partido inaugural. En 2021 conquistó por primera vez la Copa Africana de Naciones, consolidándose como una potencia regional. Es reconocida por su fortaleza física, velocidad y talento, con figuras recientes como Sadio Mané.',    
                'grupo' => 9,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Irak',
                'codigo_iso' => 'IQ',
                'imagen' => '/images/selecciones/iq.png',
                'descripcion' => 'La selección nacional de fútbol de Irak es una de las más destacadas del fútbol asiático occidental. Su mayor logro fue la conquista de la Copa Asiática en 2007, un triunfo histórico que unió al país en medio de un período difícil. También ha participado en la Copa Mundial de la FIFA en México 1986. Es reconocida por su intensidad competitiva, carácter combativo y el desarrollo progresivo de talento dentro de la región.',
                'grupo' => 9,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Noruega',
                'codigo_iso' => 'NO',
                'imagen' => '/images/selecciones/no.jpg',
                'descripcion' => 'La selección nacional de fútbol de Noruega ha tenido participaciones destacadas en la escena internacional, clasificando a las Copas del Mundo de 1938, 1994 y 1998, alcanzando los octavos de final en esta última. Es reconocida por su fortaleza física y organización táctica. En la actualidad cuenta con una generación talentosa encabezada por figuras como Erling Haaland y Martin Ødegaard, que compiten en las principales ligas europeas.',
                'grupo' => 9,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO J (10)
            // ======================
            [
                'nombre' => 'Argentina',
                'codigo_iso' => 'AR',
                'imagen' => '/images/selecciones/ar.jpg',
                'descripcion' => 'La selección nacional de fútbol de Argentina es una de las más exitosas y tradicionales del mundo. Ha conquistado la Copa Mundial de la FIFA en 1978, 1986 y 2022, además de múltiples Copas América y una Copa Confederaciones. Es reconocida por su talento individual, identidad competitiva y una rica historia de figuras legendarias como Diego Maradona y Lionel Messi. Argentina ha sido protagonista constante en torneos internacionales y es considerada una de las grandes potencias del fútbol mundial.',
                'grupo' => 10,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Argelia',
                'codigo_iso' => 'DZ',
                'imagen' => '/images/selecciones/dz.jpg',
                'descripcion' => 'La selección nacional de fútbol de Argelia es una de las principales representantes del fútbol africano. Ha participado en varias Copas del Mundo, alcanzando los octavos de final en Brasil 2014 como su mejor actuación histórica. Ha conquistado la Copa Africana de Naciones en 1990 y 2019, consolidándose como una potencia continental. Es reconocida por su velocidad, talento ofensivo y jugadores destacados que compiten en ligas europeas.',
                'grupo' => 10,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Austria',
                'codigo_iso' => 'AT',
                'imagen' => '/images/selecciones/at.jpg',
                'descripcion' => 'La selección nacional de fútbol de Austria posee una larga tradición en el fútbol europeo. Fue una de las potencias en las primeras décadas del siglo XX, alcanzando las semifinales de la Copa Mundial en 1934 y obteniendo el tercer lugar en 1954. En la actualidad se caracteriza por su organización táctica, presión intensa y desarrollo constante de talento que compite en las principales ligas europeas. Austria ha logrado consolidarse nuevamente como una selección competitiva en el panorama continental.',
                'grupo' => 10,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Jordania',
                'codigo_iso' => 'JO',
                'imagen' => '/images/selecciones/jo.jpg',
                'descripcion' => 'La selección nacional de fútbol de Jordania representa al país en competiciones internacionales dentro de la Confederación Asiática de Fútbol (AFC). Ha mostrado un crecimiento progresivo en los últimos años, destacándose en torneos regionales y alcanzando instancias avanzadas en la Copa Asiática. Es reconocida por su disciplina táctica, orden defensivo y evolución constante dentro del fútbol asiático.',
                'grupo' => 10,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO K (11)
            // ======================
            [
                'nombre' => 'Portugal',
                'codigo_iso' => 'PT',
                'imagen' => '/images/selecciones/pt.jpg',
                'descripcion' => 'La selección nacional de fútbol de Portugal es una de las potencias europeas contemporáneas. Su mayor logro fue la conquista de la Eurocopa en 2016 y la Liga de Naciones de la UEFA en 2019. En la Copa Mundial de la FIFA alcanzó el tercer lugar en 1966 y el cuarto puesto en 2006. Es reconocida por su talento ofensivo y por haber contado con figuras históricas como Eusébio y Cristiano Ronaldo, uno de los máximos goleadores internacionales de la historia.',
                'grupo' => 11,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'RD Congo',
                'codigo_iso' => 'CD',
                'imagen' => '/images/selecciones/cd.png',
                'descripcion' => 'La selección nacional de fútbol de la República Democrática del Congo, conocida anteriormente como Zaire, es una de las históricas del continente africano. Fue la primera selección del África subsahariana en participar en una Copa Mundial de la FIFA en 1974. Ha conquistado la Copa Africana de Naciones en 1968 y 1974. Es reconocida por su tradición futbolística, potencia física y el desarrollo constante de talento dentro del fútbol africano.',
                'grupo' => 11,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Uzbekistán',
                'codigo_iso' => 'UZ',
                'imagen' => '/images/selecciones/uz.jpg',
                'descripcion' => 'La selección nacional de fútbol de Uzbekistán es una de las emergentes del continente asiático desde su independencia en 1991. Ha sido competitiva en la Copa Asiática, alcanzando las semifinales en 2011 como su mejor actuación histórica. Aunque aún no ha clasificado a una Copa Mundial de la FIFA, se ha consolidado como una selección fuerte en Asia Central, destacándose por su disciplina táctica y desarrollo progresivo en torneos juveniles y continentales.',
                'grupo' => 11,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Colombia',
                'codigo_iso' => 'CO',
                'imagen' => '/images/selecciones/co.jpg',
                'descripcion' => 'La selección nacional de fútbol de Colombia es una de las protagonistas tradicionales de la Conmebol. Ha participado en múltiples Copas del Mundo, alcanzando los cuartos de final en Brasil 2014 como su mejor resultado histórico. También conquistó la Copa América en 2001 y ha sido subcampeona en varias ocasiones. Es reconocida por su talento ofensivo, técnica individual y por haber contado con figuras destacadas como Carlos Valderrama, James Rodríguez y Radamel Falcao.',
                'grupo' => 11,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

            // ======================
            // GRUPO L (12)
            // ======================
            [
                'nombre' => 'Inglaterra',
                'codigo_iso' => 'GB-ENG',
                'imagen' => '/images/selecciones/gb-eng.jpg',
                'descripcion' => 'La selección nacional de fútbol de Inglaterra es una de las más históricas del mundo y disputó el primer partido internacional oficial en 1872 frente a Escocia. Su mayor logro fue la conquista de la Copa Mundial de la FIFA en 1966, torneo que organizó como anfitriona. Ha sido protagonista constante en Eurocopas y Mundiales, destacándose por su fortaleza física, tradición futbolística y una base sólida de jugadores provenientes de una de las ligas más competitivas del mundo.',
                'grupo' => 12,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Croacia',
                'codigo_iso' => 'HR',
                'imagen' => '/images/selecciones/hr.jpg',
                'descripcion' => 'La selección nacional de fútbol de Croacia se ha consolidado como una de las grandes potencias europeas desde su independencia en la década de 1990. Alcanzó el subcampeonato mundial en 2018 y el tercer lugar en 1998 y 2022, logrando resultados históricos para un país de población reducida. Es reconocida por su calidad técnica, fortaleza competitiva y una generación dorada encabezada por figuras como Luka Modrić, Ivan Rakitić y Davor Šuker.',
                'grupo' => 12,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Ghana',
                'codigo_iso' => 'GH',
                'imagen' => '/images/selecciones/gh.jpg',
                'descripcion' => 'La selección nacional de fútbol de Ghana es una de las más competitivas del continente africano. Ha participado en varias Copas del Mundo desde su debut en 2006, alcanzando los cuartos de final en Sudáfrica 2010, su mejor actuación histórica. Ghana también ha sido campeona de la Copa Africana de Naciones en múltiples ocasiones y es reconocida por su fortaleza física, talento ofensivo y tradición en torneos juveniles, donde ha conseguido títulos mundiales.',
                'grupo' => 12,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                'nombre' => 'Panamá',
                'codigo_iso' => 'PA',
                'imagen' => '/images/selecciones/pa.jpg',
                'descripcion' => 'La selección nacional de fútbol de Panamá representa al país en competiciones internacionales dentro de la Concacaf. Logró su primera clasificación a una Copa Mundial de la FIFA en Rusia 2018, marcando un hito histórico para el fútbol panameño. Ha sido subcampeona de la Copa Oro y se ha consolidado como una selección competitiva en la región centroamericana. Es reconocida por su intensidad, disciplina táctica y crecimiento sostenido en los últimos años.',
                'grupo' => 12,
                'created_at' => (Carbon::now())->toDateTimeString()
            ],

        ];

        DB::table('equipos')->insert($equipos);
    }
}
