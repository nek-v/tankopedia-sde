tankopedia-sde
==============

This creates a local copy of that command data service Tankopedia.
For details, see the following link: https://ru.wargaming.net/developers/api_reference/

## Resources
* [Yii Framework](http://yiiframework.com)
* [Phing](http://www.phing.info)
* [Wargaming.Net](https://ru.wargaming.net/developers/)

## Installation

Download and extract tankopedia-sde

Install [phing](https://github.com/phingofficial/phing) via composer:

```bash
composer global require phing/phing
```

Run phing in the directory with the project:

```bash
phing deploy
```
During the installation, enter your application_id at [Wargaming.net](https://ru.wargaming.net/developers/applications/)

## Usage

```bash
yii dump --stdout --info --pretty
```

## More usage

* yii dump/all                It includes all of the following options
* yii dump/achievements       Get Achievements
* yii dump/arenas             Get Arenas
* yii dump/boosters           Get Boosters
* yii dump/info               Get Info
* yii dump/personal-missions  Get Personal Missions
* yii dump/provisions         Get Provisions
* yii dump/tank-chassis       Get Tank Chassis
* yii dump/tank-engines       Get Tank Engines
* yii dump/tank-guns          Get Tank Guns
* yii dump/tank-radios        Get Tank Radios
* yii dump/tank-turrets       Get Tank Turrets
* yii dump/tanks              Get Tanks
* yii dump/vehicles           Get Vehicles

 
## ADVANCED PARAMETERS
* --language Set Localization language. Default: EN
* --pretty Enable Pretty JSON output. Default: disable
* --stdout Enable stdout output.

