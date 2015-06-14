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
yiic dump --stdout --info --pretty
```

## More params

### BASIC PARAMETERS
--all It includes all of the following options
--achievements Get Achievements
--arenas Get Arenas
--info Get Tankopedia info
--personalmissions Get Personal Missions
--provisions Get Equipment and Consumables
--tankchassis Get Suspensions
--tankengines Get Engines
--tankguns Get Guns
--tankinfo Get Vehicle details
--tankradios Get Radios
--tanks Get List of vehicles
--tankturrets Get Turrets
--vehicleprofile Get Vehicle characteristics
--vehicles Get Vehicles
 
### ADVANCED PARAMETERS
--language Set Localization language. Default: EN
--pretty Enable Pretty JSON output. Default: disable
--stdout Enable stdout output.

