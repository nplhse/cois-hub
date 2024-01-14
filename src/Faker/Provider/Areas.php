<?php

namespace App\Faker\Provider;

use Faker\Provider\Base;

class Areas extends Base
{
    /** @var string[] */
    protected static $districts = [
        'Aachen', 'Ahrweiler', 'Aichach-Friedberg', 'Ammerland', 'Ansbach', 'Aschaffenburg',
        'Bad Dürkheim', 'Bad Kissingen', 'Bergstraße', 'Bernkastel-Wittlich', 'Borken',
        'Celle', 'Cloppenburg', 'Coburg', 'Coesfeld', 'Cuxhaven',
        'Dahme-Spreewald', 'Darmstadt-Dieburg', 'Diepholz', 'Dithmarschen', 'Donnersbergkreis', 'Düren',
        'Eichsfeld', 'Elbe-Elster', 'Emmendingen', 'Emsland', 'Euskirchen',
        'Frankfurt am Main', 'Forchheim', 'Freudenstadt', 'Freyung-Grafenau', 'Friesland', 'Fulda',
        'Germersheim', 'Gießen', 'Gifhorn', 'Göppingen', 'Goßlar', 'Göttingen', 'Groß-Gerau', 'Gütersloh',
        'Hameln-Pyrmont', 'Hannover', 'Harburg', 'Heidekreis', 'Helmstedt', 'Hersfeld-Rotenburg', 'Hildesheim', 'Hochtaunuskreis',
        'Ilm-Kreis',
        'Karlsruhe', 'Kassel', 'Kleve',
        'Lahn-Dill-Kreis', 'Leer', 'Limburg-Weilburg', 'Lüchow-Dannenberg', 'Lüneburg',
        'Main-Kinzig-Kreis', 'Main-Taunus-Kreis', 'Marburg-Biedenkopf', 'Mettmann', 'Minden-Lübbecke',
        'Neckar-Odenwald-Kreis', 'Neuburg-Schrobenhausen', 'Neumarkt in der Oberpfalz', 'Nienburg/Weser', 'Northeim',
        'Oberbergischer Kreis', 'Odenwaldkreis', 'Offenbach', 'Oldenburg', 'Osterholz',
        'Paderborn', 'Peine', 'Pfaffenhofen an der Ilm', 'Pinneberg', 'Plön',
        'Recklinghausen', 'Rems-Murr-Kreis', 'Rhein-Erft-Kreis', 'Rheingau-Taunus-Kreis', 'Rhein-Sieg-Kreis',
        'Saale-Holzland-Kreis', 'Schaumburg', 'Schmalkalden-Meiningen', 'Schwalm-Eder-Kreis', 'Steinfurt',
        'Taunus', 'Teltow-Fläming', 'Traunstein', 'Tuttlingen',
        'Uelzen', 'Unstrut-Hainich-Kreis',
        'Vechta', 'Verden', 'Viersen', 'Vogelsbergkreis',
        'Waldeck-Frankenberg', 'Wartburgkreis', 'Weilheim-Schongau', 'Werra-Meißner-Kreis', 'Wetteraukreis',
        'Zollernalbkreis',
    ];

    public static function district(): string
    {
        return static::randomElement(static::$districts);
    }
}
