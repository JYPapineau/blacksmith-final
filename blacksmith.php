<?php
session_start();

/**
 * createGameData
 * Creates a new session data
 * 
 * @return bool
 */
function createGameData () {
  $_SESSION['blacksmith'] = [
    'response' => [],
    'gold' => 15,
    'wood' => 0,
    'ore' => 0,
    'sword' => 0,
    'axe' => 0,
    'staff' => 0,
    'fire' => false
  ];

  return isset($_SESSION['blacksmith']);
}

/**
 * getResponse
 * Gets the response history array from the session and converts to a string
 * 
 * @return string
 */
function getResponse () {
  return implode('<br><br>', $_SESSION['blacksmith']['response']);
}

/**
 * updateResponse
 * Adds a new response to the response history array found in session
 * Get the full response history from getResponse
 * 
 * @param [string] $response
 * @return string
 */
function updateResponse ($response) {
  if (!isset($_SESSION['blacksmith'])) {
    createGameData();
  } 

  array_push($_SESSION['blacksmith']['response'], $response);

  return getResponse();
}

/**
 * fire
 * Used to start/stop the fire
 * Updates the Session data
 * 
 * @return string
 */
function fire () {
  if ($_SESSION['blacksmith']['fire']) {
    $_SESSION['blacksmith']["fire"] = false;
    return "You have put out the fire";
  } else {
    if ($_SESSION['blacksmith']['wood'] > 0) {
      $_SESSION['blacksmith']["wood"]--;
      $_SESSION['blacksmith']["fire"] = true;
      return "You have started a fire";
    } else {
      return "You do not have enough wood";
    }
  }
}

/**
 * buy
 * Used to buy items (wood or ore)
 * Updates the session data
 * 
 * @param [string] $item
 * @return string
 */
function buy ($item) {
  if ($_SESSION['blacksmith']['fire']) {
    return "You must put out the fire";
  } else {
    if (isset($item)) {
      if (isset(SETTINGS[$item])) {
        if ($_SESSION['blacksmith']['gold'] >= SETTINGS[$item]['gold']) {
          $_SESSION['blacksmith'][$item]++;
          $_SESSION['blacksmith']['gold'] -= SETTINGS[$item]['gold'];

          return "You have bought 1 piece of {$item}.";
        } else {
          return "You do not have enough gold.";
        }
      } else {
        return "You cannot buy a {$item}.";
      }
    } else {
      return "You must choose an item to buy.";
    }
  }
}

/**
 * make
 * Used to make new items (swords, axes, or staffs)
 * Updates the session data
 * 
 * @param [string] $item
 * @return string
 */
function make ($item) {
  if (!$_SESSION['blacksmith']['fire']) {
    return "You must start the fire";
  } else {
    if (isset($item)) {
      if (isset(SETTINGS[$item])) {
        if ($_SESSION['blacksmith']['wood'] >= SETTINGS[$item]['wood'] && $_SESSION['blacksmith']['ore'] >= SETTINGS[$item]['ore']) {
          $_SESSION['blacksmith'][$item]++;
          $_SESSION['blacksmith']['wood'] -= SETTINGS[$item]['wood'];
          $_SESSION['blacksmith']['ore'] -= SETTINGS[$item]['ore'];

          return "You have made 1 {$item}.";
        } else {
          return "You do not have enough resources.";
        }
      } else {
        return "You cannot make a {$item}.";
      }
    } else {
      return "You must choose an item to make.";
    }
  }
}

/**
 * sell
 * Used to sell items (wood, ore, swords, axes, or staffs)
 * Updates the session data
 *
 * @param [string] $item
 * @return string
 */
function sell ($item) {
  if ($_SESSION['blacksmith']['fire']) {
    return "You must put out the fire";
  } else {
    if (isset($item)) {
      if (isset(SETTINGS[$item])) {
        if ($_SESSION['blacksmith'][$item]) {
          $price = rand(SETTINGS[$item]['sell_min'], SETTINGS[$item]['sell_max']);

          $_SESSION['blacksmith']['gold'] += $price;
          $_SESSION['blacksmith'][$item]--;
          
          if ($price === 1) {
            return "You have sold 1 {$item} for {$price} piece of gold.";
          } else {
            return "You have sold 1 {$item} for {$price} pieces of gold.";
          }
          
        } else {
          return "You do not have that item.";
        }
      } else {
        return "You cannot sell {$item}.";
      }
    } else {
      return "You must choose an item to sell.";
    }
  }
}


/**
 * inventory
 * Used to return session data (formatted)
 * 
 * @return string
 */
function inventory () {
  $responses = '';

  foreach ($_SESSION['blacksmith'] as $item => $value) {
    if ($item === 'fire') {
      if ($value) {
        $responses .= "The fire is going";
      } else {
        $responses .= "The fire is out";
      }
    } else if (!is_array($value)) {
      $responses .= "{$value} ${item}<br>";
    }
  }

  return $responses;
}

/**
 * restart
 * Used to clear session data and start over
 * Updates the session data
 *  
 * @return string
 */
function restart () {
  createGameData();
  
  return 'The game has restarted';
}

/**
 * help
 * Returns a formatted string of game instructions
 * 
 * @return string
 */
function help () {
  return 'Welcome to Blacksmith, the text based blacksmith game. Use the following commands to play the game: <span class="red">buy <em>item</em></span>, <span class="red">sell <em>item</em></span>, <span class="red">make <em>item</em></span>, <span class="red">fire</span>. To restart the game use the <span class="red">restart</span> command For these instruction again use the <span class="red">help</span> command';
}

/**
 * Create a response based on the players commands
 * - If the player has entered a command 
 *    - extract the command from the player's input
 *      - the explode function will split the input on the space separate the 
 *        command from the option
 *    - check if the entered command is a valid function using function_exists
 *      - check for a command option
 *        - execute command with option using the variable function technique
 *        - updateResponse with function's results
 *      - else
 *        - execute command using the variable function technique
 *        - updateResponse with function's results
 *    - else
 *      - updateResponse with invalid command  
 */
if (isset($_POST['command'])) {
  $command = explode(' ', strtolower($_POST['command']));
  if (function_exists($command[0])) {
    if (isset($command[1])) {
      updateResponse($command[0]($command[1]));
    } else {
      updateResponse($command[0]());
    }
  } else {
    updateResponse("{$_POST['command']} is not a valid command");
  }
}
