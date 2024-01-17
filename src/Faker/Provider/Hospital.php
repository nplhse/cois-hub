<?php

namespace App\Faker\Provider;

use Faker\Provider\Base;

class Hospital extends Base
{
    /** @var string[] */
    protected static $formats = [
        '{{hospitalName}}{{hospitalSuffix}}',
        '{{hospitalPrefix}} {{hospitalName}}',
        '{{hospitalName}} {{city}}',
        '{{city}}{{hospitalSuffix}}',
    ];

    /** @var string[] */
    protected static $hospitalName = [
        'Auguste-Viktoria', 'Anna', 'Albert-Schweitzer', 'Albertinen', 'Allgemeines', 'Annastift', 'Ammerland', 'Augustinerinnen',
        'Bethlehem', 'Bürgerhospital', 'Bernward', 'Brüderkrankenhaus', 'Bethesda', 'Bonifatius',
        'Christliches',
        'Dreifaltigkeits', 'Diakonissenanstalt',
        'Elisabeth',
        'Gesundheitszentrum', 'Grüner Kreis',
        'Hedwigshöhe', 'Hedwig', 'Hubertus', 'Heckeshorn', 'Hermann-Josef', 'Hellmig', 'Hospital zum Heiligen Geist ', 'Herz- und Gefäßzentrum', 'Heinrich-Braun',
        'Franziskus', 'Fachkrankenhaus', 'Fachklinik', 'Friederikenstift',
        'Immanuel',
        'Johanniter',
        'Krankenhaus', 'Kreiskrankenhaus', 'Katharinen', 'Kreis Krankenhaus', 'Kliniken', 'Klinikzentrum',
        'Lungenklinik', 'Luisenhospital', 'Lukas-Krankenhaus',
        'Marienkrankenhaus', 'Martin-Luther', 'Maria-Hilf', 'Marienhospital', 'Mariahilf', 'Marien Hospital',
        'Nordwest',
        'Oberhavel', 'Ostsee',
        'Prosper-Hospital',
        'Rhein-Ruhr', 'Rudolf-Virchow',
        'Unfallkrankenhaus', 'Universitätskrankenhaus',
        'Schlosspark', 'Sanatorium', 'Städtisches', 'Stiftshospital', 'Städtische Kliniken', 'St. Marien', 'Spital', 'Stadtkrankenhaus',
        'Waldkrankenhaus', 'Waldfriede', 'Weidlandkliniken',
        'Vinzenz',
    ];

    /** @var string[] */
    protected static $hospitalPrefix = [
        'Apollon',
        'DGR Kliniken',
        'Evangelisches',
        'Hyperion',
        'Klinikum',
        'Sankt', 'St.', 'St. Joseph', 'St. Marien', 'St. Johannes', 'St. Theresien', 'St. Vincentius', 'Spital', 'St. Vincenz',
    ];

    /** @var string[] */
    protected static $hospitalSuffix = [
        '-Klinikum', ' Klinikum', '-Krankenhaus',
    ];

    public function hospitalName(): string
    {
        return static::randomElement(static::$hospitalName);
    }

    public function hospitalPrefix(): string
    {
        return static::randomElement(static::$hospitalPrefix);
    }

    public function hospitalSuffix(): string
    {
        return static::randomElement(static::$hospitalSuffix);
    }

    public function hospital(): string
    {
        $format = static::randomElement(static::$formats);

        return $this->generator->parse($format);
    }
}
