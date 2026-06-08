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
            'Honda' => ['Accord', 'Civic', 'City', 'CR-V', 'Fit', 'HR-V', 'WR-V'],
            'Hyundai' => ['Azera', 'Creta', 'HB20', 'HB20S', 'i30', 'ix35', 'Santa Fe', 'Tucson', 'Veloster', 'Veracruz'],
            'Jeep' => ['Commander', 'Compass', 'Grand Cherokee', 'Renegade', 'Wrangler'],
            'Kia' => ['Bongo', 'Cerato', 'Picanto', 'Sorento', 'Soul', 'Sportage'],
            'Mitsubishi' => ['ASX', 'Eclipse Cross', 'L200', 'Outlander', 'Pajero', 'Pajero TR4'],
            'Nissan' => ['Frontier', 'Kicks', 'Livina', 'March', 'Sentra', 'Tiida', 'Versa', 'X-Trail'],
            'Peugeot' => ['206', '207', '208', '2008', '307', '308', '3008', '408', 'Partner'],
            'Renault' => ['Captur', 'Clio', 'Duster', 'Fluence', 'Kangoo', 'Kwid', 'Logan', 'Megane', 'Oroch', 'Sandero', 'Scenic', 'Symbol'],
            'Toyota' => ['Camry', 'Corolla', 'Corolla Cross', 'Etios', 'Hilux', 'RAV4', 'SW4', 'Yaris'],
            'Volkswagen' => ['Amarok', 'Fox', 'Gol', 'Golf', 'Jetta', 'Nivus', 'Parati', 'Passat', 'Polo', 'Saveiro', 'T-Cross', 'Taos', 'Tiguan', 'Up', 'Virtus', 'Voyage'],
        ];
    }

    public static function modeloValido(string $marca, string $modelo): bool
    {
        $catalogo = self::marcasModelos();
        return isset($catalogo[$marca]) && in_array($modelo, $catalogo[$marca], true);
    }
}
