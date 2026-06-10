<?php

class VeiculoCatalogo
{
    public static function marcasModelos(): array
    {
        return [
            'Chevrolet' => ['Astra', 'Celta', 'Classic', 'Cobalt', 'Corsa', 'Cruze', 'Meriva', 'Montana', 'Onix', 'Prisma', 'S10', 'Spin', 'Tracker', 'Vectra', 'Zafira'],
            'Citroen' => ['Aircross', 'Berlingo', 'C3', 'C3 Picasso', 'C4', 'C4 Cactus', 'C4 Lounge', 'Xsara Picasso'],
            'Fiat' => ['Argo', 'Bravo', 'Cronos', 'Doblo', 'Ducato', 'Fastback', 'Fiorino', 'Idea', 'Linea', 'Mobi', 'Palio', 'Pulse', 'Punto', 'Siena', 'Stilo', 'Strada', 'Toro', 'Uno'],
            'Ford' => ['Courier', 'EcoSport', 'Edge', 'Fiesta', 'Focus', 'Fusion', 'Ka', 'Maverick', 'Ranger', 'Territory'],
            'Haojue' => ['Chopper Road', 'DK 150', 'DR 160', 'Lindy 125', 'Master Ride', 'Nex 115'],
            'Honda' => ['Accord', 'Biz 110i', 'Biz 125', 'CB 300F', 'CB 500F', 'CB 500X', 'CB 650R', 'Civic', 'City', 'CG 125', 'CG 150', 'CG 160', 'CR-V', 'Elite 125', 'Fit', 'HR-V', 'NXR Bros 150', 'NXR Bros 160', 'PCX 150', 'PCX 160', 'Pop 100', 'Pop 110i', 'Twister 250', 'WR-V', 'XRE 190', 'XRE 300', 'XRE 300 Sahara'],
            'Hyundai' => ['Azera', 'Creta', 'HB20', 'HB20S', 'i30', 'ix35', 'Santa Fe', 'Tucson', 'Veloster', 'Veracruz'],
            'Jeep' => ['Commander', 'Compass', 'Grand Cherokee', 'Renegade', 'Wrangler'],
            'Kia' => ['Bongo', 'Cerato', 'Picanto', 'Sorento', 'Soul', 'Sportage'],
            'Mitsubishi' => ['ASX', 'Eclipse Cross', 'L200', 'Outlander', 'Pajero', 'Pajero TR4'],
            'Nissan' => ['Frontier', 'Kicks', 'Livina', 'March', 'Sentra', 'Tiida', 'Versa', 'X-Trail'],
            'Peugeot' => ['206', '207', '208', '2008', '307', '308', '3008', '408', 'Partner'],
            'Renault' => ['Captur', 'Clio', 'Duster', 'Fluence', 'Kangoo', 'Kwid', 'Logan', 'Megane', 'Oroch', 'Sandero', 'Scenic', 'Symbol'],
            'Toyota' => ['Camry', 'Corolla', 'Corolla Cross', 'Etios', 'Hilux', 'RAV4', 'SW4', 'Yaris'],
            'Shineray' => ['Jet 125', 'Jef 150', 'Phoenix 50', 'Rio 125', 'Worker 125', 'XY 150'],
            'Suzuki' => ['Burgman 125', 'DL 650 V-Strom', 'GSX-S 750', 'Intruder 125', 'Yes 125'],
            'Volkswagen' => ['Amarok', 'Fox', 'Gol', 'Golf', 'Jetta', 'Nivus', 'Parati', 'Passat', 'Polo', 'Saveiro', 'T-Cross', 'Taos', 'Tiguan', 'Up', 'Virtus', 'Voyage'],
            'Yamaha' => ['Crypton 115', 'Factor 125', 'Factor 150', 'Fazer 150', 'Fazer 250', 'Fluo 125', 'Lander 250', 'MT-03', 'NMAX 160', 'Neo 125', 'R3', 'Tenere 250', 'XMAX 250', 'XTZ 125'],
        ];
    }

    public static function modeloValido(string $marca, string $modelo): bool
    {
        $catalogo = self::marcasModelos();
        return isset($catalogo[$marca]) && in_array($modelo, $catalogo[$marca], true);
    }
}
