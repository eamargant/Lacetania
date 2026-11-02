<?php
return [
    'usuaris' => [
        ['email' => 'anna@lacetania.cat', 'nom' => 'Anna',
         'contrasenya' => '$2y$10$cOSouIhiXxDCeWqbR/v5W.7gR5eEt3UlV/CTiFzMZLJhVNZ6u5NSu', 'rol' => 'votant'],
        ['email' => 'pau@lacetania.cat', 'nom' => 'Pau',
         'contrasenya' => '$2y$10$cOSouIhiXxDCeWqbR/v5W.7gR5eEt3UlV/CTiFzMZLJhVNZ6u5NSu', 'rol' => 'votant'],
        ['email' => 'laia@lacetania.cat', 'nom' => 'Laia',
         'contrasenya' => '$2y$10$cOSouIhiXxDCeWqbR/v5W.7gR5eEt3UlV/CTiFzMZLJhVNZ6u5NSu', 'rol' => 'votant'],
        ['email' => 'tutora@lacetania.cat', 'nom' => 'Tutora',
         'contrasenya' => '$2y$10$6PPLcaRwvdEEQN6a.PtJaeY4YEM971VOyJ6eVW4JAxXhEPxodZ6vq', 'rol' => 'admin'],
    ],
    'consulta' => [
        'pregunta'  => 'Voleu que la sortida de final de curs sigui de dos dies?',
        'opcions'   => [
            'si'    => 'Sí',
            'no'    => 'No',
            'blanc' => 'Vot en blanc',
        ],
        'tancament' => '2026-12-18 14:00',
    ],
];
