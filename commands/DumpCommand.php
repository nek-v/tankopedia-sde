<?php

class DumpCommand extends CConsoleCommand {

    /**
     * @var boolean
     */
    public $all;

    /**
     * Achievements
     * 
     * @var boolean
     */
    public $achievements;

    /**
     * Maps
     * 
     * @var boolean
     */
    public $arenas;
    
    /**
     * Boosters
     * 
     * @var boolean
     */
    public $boosters;

    /**
     * Tankopedia information
     * 
     * @var boolean
     */
    public $info;

    /**
     * Personal Missions
     * 
     * @var boolean
     */
    public $personalmissions;
    
    /**
     * Provisions
     * 
     * @var boolean
     */
    public $provisions;

    /**
     * Suspensions
     * 
     * @var boolean
     */
    public $tankchassis;

    /**
     * Engines
     * 
     * @var boolean
     */
    public $tankengines;

    /**
     * Guns
     * 
     * @var boolean
     */
    public $tankguns;

    /**
     * Radios
     * 
     * @var boolean
     */
    public $tankradios;

    /**
     * List of vehicles
     * 
     * @var boolean
     */
    public $tanks;

    /**
     * Turrets
     * 
     * @var boolean
     */
    public $tankturrets;

    /**
     * Vehicles
     * 
     * @var boolean
     */
    public $vehicles;

    /**
     * @var boolean
     */
    public $debug;

    /**
     * @var boolean
     */
    public $verbose;

    /**
     * <ul>
     * <li>"en" — English
     * <li>"ru" — Русский
     * <li>"pl" — Polski
     * <li>"de" — Deutsch
     * <li>"fr" — Français
     * <li>"es" — Español
     * <li>"zh-cn" — 简体中文
     * <li>"tr" — Türkçe
     * <li>"cs" — Čeština
     * <li>"th" — ไทย
     * <li>"vi" — Tiếng Việt
     * <li>"ko" — 한국어
     * </ul>
     * 
     * @var string
     */
    public $language = 'en';

    /**
     * Enable Pretty output
     * 
     * @var boolean
     */
    public $pretty;

    /**
     * Enable stdout output
     * 
     * @var boolean
     */
    public $stdout;

    /**
     * @var string
     */
    private $item;

    /**
     * @return string
     */
    public function getHelp() {
        return <<<EOD
USAGE yiic dump <parameters>

DESRIPTION
  This creates a local copy of that command data service Tankopedia.
  For details, see the following link: https://ru.wargaming.net/developers/api_reference/

BASIC PARAMETERS
  --all It includes all of the following options
  --achievements Get Achievements
  --arenas Get Arenas
  --info Get Tankopedia info
  --personalmissions Get Personal Missions
  --provisions Get Equipment and Consumables
  --tankchassis Get Suspensions
  --tankengines Get Engines
  --tankguns Get Guns
  --tankradios Get Radios
  --tanks Get List of vehicles
  --tankturrets Get Turrets
  --vehicles Get Vehicles
 
ADVANCED PARAMETERS
  --language Set Localization language. Default: EN
  --pretty Enable Pretty JSON output. Default: disable
  --stdout Enable stdout output.

EXAMPLE
  yiic dump --all --pretty --language=ru
EOD;
    }

    /**
     * 
     */
    public function actionIndex() {
        // @todo WTF, guy?
        if (isset($this->all)) {
            $this->getAll();
        } else if (isset($this->achievements)) {
            $this->item = 'achievements';
            $this->getItem();
        } else if (isset($this->arenas)) {
            $this->item = 'arenas';
            $this->getItem();
        } else if (isset($this->boosters)) {
            $this->item = 'boosters';
            $this->getItem();
        } else if (isset($this->info)) {
            $this->item = 'info';
            $this->getItem();
        } else if (isset($this->personalmissions)) {
            $this->item = 'personalmissions';
            $this->getItem();
        } else if (isset($this->provisions)) {
            $this->item = 'provisions';
            $this->getItem();
        } else if (isset($this->tankchassis)) {
            $this->item = 'tankchassis';
            $this->getItem();
        } else if (isset($this->tankengines)) {
            $this->item = 'tankengines';
            $this->getItem();
        } else if (isset($this->tankguns)) {
            $this->item = 'tankguns';
            $this->getItem();
        } else if (isset($this->tankradios)) {
            $this->item = 'tankradios';
            $this->getItem();
        } else if (isset($this->tanks)) {
            $this->item = 'tanks';
            $this->getItem();
        } else if (isset($this->tankturrets)) {
            $this->item = 'tankturrets';
            $this->getItem();
        } else if (isset($this->vehicles)) {
            $this->item = 'vehicles';
            $this->getItem();
        } else {
            echo $this->getHelp();
        }
    }

    /**
     * @return int
     */
    private function getAll() {
        $source = [
            'achievements', 'arenas', 'boosters', 'info', 'personalmissions',
            'provisions', 'tankchassis', 'tankengines', 'tankguns', 'tankradios',
            'tanks', 'tankturrets', 'vehicles'
        ];
        $path = dirname(__FILE__) . '/../data/';
        foreach ($source as $item) {
            $params = http_build_query([
                'application_id' => Yii::app()->params['appId'],
                'language' => $this->language
            ]);
            $url = 'https://api.worldoftanks.ru/wot/encyclopedia/' . $item . '/?' . $params;
            $responce = $this->requestHttp($url);
            $str = str_replace('http:', 'https:', $responce);
            if (isset($this->pretty)) {
                $str = $this->pretty($str);
            }
            if (isset($this->stdout)) {
                echo $str;
            }
            file_put_contents($path . $item . '.json', $str);
        }
        return 0;
    }

    /**
     * @return int
     */
    private function getItem() {
        $params = http_build_query([
            'application_id' => Yii::app()->params['appId'],
            'language' => $this->language
        ]);
        $url = 'https://api.worldoftanks.ru/wot/encyclopedia/' . $this->item . '/?' . $params;
        $responce = $this->requestHttp($url);
        $str = str_replace('http:', 'https:', $responce);
        $path = dirname(__FILE__) . '/../data/';
        if (isset($this->pretty)) {
            $str = $this->pretty($str);
        }
        if (isset($this->stdout)) {
            echo $str;
        }
        file_put_contents($path . $this->item . '.json', $str);
        return 0;
    }

    /**
     * @param string $url
     * @param string $method
     * @return string
     */
    private static function requestHttp($url, $method='POST') {
        $options = [
            'http' => [
                'method' => $method,
                'user_agent' => 'FapStatCrawler/0.1.1 (+http://fapstat.ru)'
            ]
        ];
        $context = stream_context_create($options);
        $data = file_get_contents($url, false, $context);
        return $data;
    }

    /**
     * @link http://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
     * @param string $json
     * @return string
     */
    private function pretty($json) {

        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '  ';
        $newLine = "\n";
        $prevChar = '';
        $outOfQuotes = true;

        for ($i = 0; $i <= $strLen; $i++) {
            $char = substr($json, $i, 1);
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;
            } else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
            $result .= $char;
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
            $prevChar = $char;
        }
        return $result;
    }

}
