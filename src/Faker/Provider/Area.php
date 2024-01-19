<?php

namespace App\Faker\Provider;

use Faker\Provider\Base;

class Area extends Base
{
    /** @var string[] */
    protected static $districts = [
        'Aachen', 'Ahrweiler', 'Aichach-Friedberg', 'Alb-Donau-Kreis', 'Altenburger Land', 'Altenkirchen', 'Altmarkkreis Salzwedel', 'Altötting', 'Alzey-Worms', 'Amberg-Sulzbach', 'Anhalt-Bitterfeld', 'Ammerland', 'Ansbach', 'Aschaffenburg', 'Augsburg', 'Aurich',
        'Bad Dürkheim', 'Bad Kissingen', 'Bad Kreuznach', 'Bad Tölz-Wolfratshausen', 'Bamberg', 'Barnim', 'Bautzen', 'Bayreuth', 'Berchtesgardener Land', 'Bergstraße', 'Bernkastel-Wittlich', 'Biberach', 'Birkenfeld', 'Böblingen', 'Bodenseekreis', 'Börde', 'Borken', 'Breisgau-Hochschwarzwald', 'Burgenlandkreis',
        'Calw', 'Celle', 'Cham', 'Cloppenburg', 'Coburg', 'Cochem-Zell', 'Coesfeld', 'Cuxhaven',
        'Dachau', 'Dahme-Spreewald', 'Darmstadt-Dieburg', 'Deggendorf', 'Diepholz', 'Dingolfing-Landau', 'Dithmarschen', 'Dillingen an der Donau', 'Donnersbergkreis', 'Düren', 'Donau-Ries',
        'Ebersberg', 'Eichsfeld', 'Eichstätt', 'Elbe-Elster', 'Eifelkreis Bitburg-Prüm', 'Elbe-Elster', 'Emmendingen', 'Emsland', 'Euskirchen', 'Ennepe-Ruhr-Kreis', 'Enzkreis', 'Erding', 'Erlangen-Höchstadt', 'Erzgebirgskreis', 'Esslingen', 'Euskirchen',
        'Freising', 'Frankfurt am Main', 'Freyung-Grafenau', 'Forchheim', 'Freudenstadt', 'Freyung-Grafenau', 'Friesland', 'Fulda',
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

    /** @var string[] */
    protected static $dispatchAreas = [
        'Allgäu', 'Amberg', 'Ansbach', 'Augsburg', 'Aachen', 'Altmark', 'Anhalt-Bitterfeld',
        'Bamberg-Forchheim', 'Bayreuth/Kulmbach', 'Bayerischer Untermain', 'Berlin', 'Brandenburg', 'Bergstraße', 'Braunschweig', 'Berga', 'Bielefeld', 'Bochum', 'Bonn', 'Borken', 'Bottrop', 'Börde', 'Burgenlandkreis', 'Bremen', 'Bremerhaven', 'Böblingen', 'Bodensee-Oberschwaben', 'Biberach',
        'Coburg', 'Celle', 'Cuxhaven', 'Coesfeld', 'Chemnitz', 'Calw',
        'Donau-Iller', 'Darmstadt', 'Darmstadt-Dieburg', 'Dietzenbach', 'Diepholz', 'Düsseldorf', 'Düsseldorf', 'Dortmund', 'Düren', 'Dresden', 'Dessau',
        'Erding', 'Emden', 'Ems-Vechte', 'Ennepe', 'Essen', 'Euskirchen', 'Eichsfeld', 'Erfurt', 'Esslingen', 'Emmendingen',
        'Fürstenfeldbruck', 'Frankfurt', 'Fulda', 'Friesland-Wilhelmshaven', 'Freudenstadt', 'Freiburg',
        'Gerau', 'Gießen', 'Geeste', 'Gifhorn', 'Göttingen', 'Goslar', 'Gelsenkirchen', 'Gütersloh', 'Gera', 'Gotha', 'Göppingen',
        'Hochfranken', 'Hochtaunus', 'Hersfeld-Rotenburg', 'Heidekreis', 'Hameln', 'Hannover', 'Harburg', 'Helmstedt', 'Hildesheim', 'Hagen', 'Hamm', 'Herford', 'Herne', 'Höxter', 'Heinsberg', 'Halle', 'Harz', 'Hamburg', 'Hohenlohe', 'Heilbronn', 'Heidelberg',
        'Ingolstadt', ' Ilmkreis',
        'Jerichower Land', 'Jena',
        'Kassel', 'Kaiser', 'Koblenz', 'Kreuznach', 'Kleve', 'Köln', 'Krefeld', 'Konstanz', 'Karlsruhe',
        'Landshut', 'Lausitz', 'Lahn-Dill', 'Limburg-Weilburg', 'Lüchow', 'Lüneburg', 'Ludwigshafen', 'Landau', 'Leverkusen', 'Lippe', 'Leipzig', 'Lübeck', 'Lörrach', 'Ludwigsburg',
        'Mittelfranken-Süd', 'München', 'Main-Taunus', 'Marburg-Biedenkopf', 'Main-Kinzig', 'Mitte', 'Mecklenburgische-Seenplatte', 'Mainz', 'Montabaur', 'Mark', 'Mettmann', 'Minden', 'Mühlheim', 'Münster', 'Magdeburg', 'Mansfeld-Südharz', 'Mitte', 'Mittelbaden', 'Mannheim', 'Main-Tauber',
        'Nordoberpfalz', 'Nürnberg', 'Nordost', 'Nordwest', 'Northeim', 'Nord', 'Neumünster', 'Nordhausen', 'Neckar-Odenwald',
        'Oberland', 'Oderland', 'Odenwald', 'Offenbach', 'Oldenburg', 'Osnabrück', 'Osterode', 'Ostfriesland', 'Oberberg', 'Oberhausen', 'Olpe', 'Ostsachsen', 'Ostalb', 'Ortenau',
        'Passau', 'Paderborn', 'Pforzheim',
        'Regensburg', 'Rosenheim', 'Rheingau-Taunus', 'Rostock', 'Rotenburg', 'Rhein-Erft Kreis', 'Rhein-Kreis-Neuss', 'Recklinghausen', 'Remscheid', 'Rhein-Sieg', 'Rottweil', 'Reutlingen', 'Rems-Murr', 'Rhein-Neckar',
        'Schweinfurt', 'Straubing', 'Traunstein', 'Schwalm-Eder', 'Salzgitter', 'Schaumburg', 'Stade', 'Siegen-Wittgenstein', 'Soest', 'Saar', 'Saalekreis', 'Salzlandkreis', 'Süd', 'Schmalkalden-Meiningen', 'Suhl', 'Schwarzwald-Baar', 'Stuttgart', 'Schwäbisch Hall',
        'Trier', 'Tuttlingen', 'Tübingen',
        'Uelzen', 'Unna', 'Unstrut-Hainich', 'Ulm',
        'Vogelsberg', ' Vorpommern-Rügen', 'Vorpommern-Greifswald', 'Vechta', 'Viersen',
        'Würzburg', 'Wetterau', 'Waldeck-Frankenberg', 'Werra-Meißner', 'Wiesbaden', 'Westmecklenburg', 'Wolfsburg', 'Worms', 'Warendorf', 'Wesel', 'Wupper', 'Wittenberg', 'Wartburgkreis', 'Weimarer Land', 'Waldshut',
        'Zwickau', 'Zollernalb',
    ];

    public function dispatchArea(): string
    {
        return static::randomElement(static::$dispatchAreas);
    }

    public function district(): string
    {
        return static::randomElement(static::$districts);
    }
}
