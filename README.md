# Blacksmith

This repository contains a completed version of Blacksmith.

## Objective
For this exercise you will practice using Functions, Includes, and the `$_POST` and `$_SESSION` variables to create a interactive, text-based blacksmith game.

## Game Play
The player is a Blacksmith who must make a living making and selling items. To do this the player will perform actions by typing in the commands into the form text box. The response for each command will be displayed in the response box. The old responses will remain on the page even as new ones come in. 

Each action may have certain conditions that must be met in order for the task to be performed. When a condition is not correct, the game must inform the player what they should do in order to perform the desired task. After an action has been performed, a status message should be present to the player explain what happened.

### Commands
#### Starting / Stopping a fire
The player can start or stop a fire. The player will start the fire only if:

- The fire has been stopped
- The player has at least 1 piece of wood

#### Buying Resources
The player will need to buy resources in order make items. The player can buy a specified resource using the `buy` command followed by an *item*, as long as the player has enough gold. The required gold can be found below. *The fire must be put out before buying any resources*

| Resource | Gold |
|:--------:|:----:|
| Wood     | 2    |
| Ore      | 4    |


#### Making Items
The player can make a specified item by using the `make` command followed by an *item*, as long as the player has enough resources for that item. The items requirements are below. *The fire must be going before making items.*

| Item   | Wood   | Ore   |
|:------:|:------:|:-----:|
| Sword  | 1      | 3     |
| Axe    | 2      | 1     |
| Staff  | 2      | 0     |

#### Selling Items and Resources
The player can sell a specified item or resource using the `sell` command followed by an *item*, as long as the player has the item or resource in inventory. The amount of Gold received from an item will be randomly determined based on a range. The ranges for each item or resource can be found below. *The fire must be put out before selling items or resources.*


| Item / Resource | Sell Min | Sell Max |
|:---------------:|:--------:|:--------:|
| Wood            | 1        | 1        |
| Ore             | 2        | 2        |
| Sword           | 12       | 20       |
| Axe             | 7        | 12       |
| Staff           | 4        | 7        |

#### Checking inventory
The player can check the inventory status using the `inventory` command. The inventory status should return a list of how many items the player currently has. 

#### Help
The player can display the instructions on how to play the game using the `help` command.

#### Restarting the Game
The player can clear the current game data by restarting the game using the `restart` command. All inventory should be set back to zero.

## Starter Files
In this repository you should find the following files:
1. The `index.php` file is the main file for the game, and contains all the HTML needed. It already links to `blacksmith.css` and `blacksmith.js`.
2. The `settings.php` file will hold the an array of settings for the game.
3. The `blacksmith.php` file will be where all the functions and logic for the Blacksmith game.

## Requirements
The following requirement must be met in order to complete the exercise successfully:

### 1. Include Project Files
In `index.php`, use the `require` statement to include the `settings.php` and `blacksmith.php` files.

### 2. Create Game Data
1. In the `blacksmith.php` file, start a new session.
2. In `blacksmith.php` create the `createGameData()` function. The function will create a game data array and store it in session under the index `blacksmith`. The game data array should contain the following:
    1. The `response` array
    2. The number of `gold`
    3. The number of `wood`
    4. The number of `ore`
    5. The number of `swords`
    6. The number of `axes`
    7. The number of `staffs`
    8. The status of `fire`

### 3. Send commands using the POST Method
In `index.php`, update the form to submit using the `POST` method.

### 4. Check the `$_POST` array
In `blacksmith.php` check for the `$_POST` array for a command from the player. 

1. If a player has entered a command, complete the following actions:
    1. Use the `explode()` function to split the command on space. This will help separate command from an option.
    2. Use the `function_exists()` function to check if the command matches a existing function
        1. If so, execute the function passing the results to the the `updateResponse()` function.
        2. If not, then add a response to response array in session, using `updateResponse()`, telling the user that the command is not valid.

### 5. Create Game Functions
Each action or command (see above), will require a function. Create the following functions with the necessary requirements:

#### 1. The `fire()` function
The `fire()` function will allow the player to start or stop the fire and should have the following requirements: 

1. If the `fire()` function is called when the fire is going it should be turned off the fire. 
2. If the `fire()` function is called when the fire is NOT going AND the player has at least 1 piece of wood, the fire should be turned on. 

#### 2. The `buy()` function
The `buy()` function will allow the player to buy a resource and should have the following requirements:

1. The function should take 1 parameter which will be the resource the player wishes to buy.
2. The function will add 1 resource to the player's inventory and remove the appropriate amount of gold from the players inventory if all of the following conditions are met:
    1. The fire is **NOT** burning 
    2. An resource is provided
    3. The resource provided is valid
    4. If the player has enough gold to buy the resource
3. A message should be returned indicating that a transaction took place or a requirement was not met. 

#### 3. The `make()` function
The `make()` function will allow the player to make an item and should have the following requirements:

1. The function should take 1 parameter which will be the item the player wishes to make.
2. The function will add 1 item to the players inventory and remove the appropriate amount of wood and / or ore from the players inventory if all of the following conditions are met:
    1. The fire is burning 
    2. An item is provided
    3. The item provided is valid
    4. If the player has enough wood and / or ore to make the item
3. A message should be returned indicating that an item was made or a requirement was not met.

#### 4. The `sell()` function
The `sell()` function will allow the player to sell an item or resource and should have the following requirements:

1. The function should take 1 parameter which will be the item or resource the player wishes to sell.
2. The function will remove 1 item or resource from the player's inventory and add a random amount of gold to the players inventory based on the item's or resource's sell range and if all of the following conditions are met:
    1. The fire is **NOT** burning 
    2. An item / resource is provided
    3. The item / resource provided is valid
    4. If the player has the item / resource they are trying to sell
3. A message should be returned indicating that an item was made or a requirement was not met. 

#### 5. The `inventory()` function
The `inventory()` function will display the players current inventory. It should list the amount of wood, ore, swords, axes, and staffs the player has as well as if the fire is going.

#### 6. The `reset()` function
The `reset()` function will clear the game data and start the game over.