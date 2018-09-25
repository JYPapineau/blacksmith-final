<?php

/* DEFINING REQUIREMENT SETTING */

// Creating a constant array for the settings
// Constants cannot be altered and are global variables
define('SETTINGS', [
  'wood' => [
    'gold' => 2,
    'sell_min' => 1,
    'sell_max' => 1
  ],
  'ore' => [
    'gold' => 4,
    'sell_min' => 2,
    'sell_max' => 2
  ],
  'sword' => [
    'wood' => 1, 
    'ore' => 3, 
    'sell_min' => 12, 
    'sell_max' => 20
  ],
  'axe' => [
    'wood' => 2,
    'ore' => 1,
    'sell_min' => 7,
    'sell_max' => 12
  ],
  'staff' => [
    'wood' => 2,
    'ore' => 0,
    'sell_min' => 4,
    'sell_max' => 7
  ]
]);