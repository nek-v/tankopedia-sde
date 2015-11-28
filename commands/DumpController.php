<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This creates a local copy of that command data service Tankopedia.
 */
class DumpController extends Controller {

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
     * Magic!
     */
    private $item;

    public function options($actionID) {
        return array_merge(
                parent::options($actionID), ['language', 'stdout', 'pretty']
        );
    }

    /**
     * Get Achievements
     */
    public function actionAchievements() {
        $this->getItem('achievements');
    }
    
    /**
     * Get Arenas
     */
    public function actionArenas() {
        $this->getItem('arenas');
    }
    
    /**
     * Get Boosters
     */
    public function actionBoosters() {
        $this->getItem('boosters');
    }
    
    /**
     * Get Info
     */
    public function actionInfo() {
        $this->getItem('info');
    }
    
    /**
     * Get Personal Missions
     */
    public function actionPersonalMissions() {
        $this->getItem('personalmissions');
    }
    
    /**
     * Get Provisions
     */
    public function actionProvisions() {
        $this->getItem('provisions');
    }
    
    /**
     * Get Tank Chassis
     */
    public function actionTankChassis() {
        $this->getItem('tankchassis');
    }
    
    /**
     * Get Tank Engines
     */
    public function actionTankEngines() {
        $this->getItem('tankengines');
    }
    
    /**
     * Get Tank Guns
     */
    public function actionTankGuns() {
        $this->getItem('tankguns');
    }
    
    /**
     * Get Tank Radios
     */
    public function actionTankRadios() {
        $this->getItem('tankradios');
    }
    
    /**
     * Get Tanks
     */
    public function actionTanks() {
        $this->getItem('tanks');
    }
    
    /**
     * Get Tank Turrets
     */
    public function actionTankTurrets() {
        $this->getItem('tankturrets');
    }
    
    /**
     * Get Vehicles
     */
    public function actionVehicles() {
        $this->getItem('vehicles');
    }
    
    /**
     * It includes all of the following options
     * 
     * @return int
     */
    public function actionAll() {
        $source = [
            'achievements', 'arenas', 'boosters', 'info', 'personalmissions',
            'provisions', 'tankchassis', 'tankengines', 'tankguns', 'tankradios',
            'tanks', 'tankturrets', 'vehicles'
        ];
        $path = dirname(__FILE__) . '/../data/';
        foreach ($source as $item) {
            $params = http_build_query([
                'application_id' => Yii::$app->params['appId'],
                'language' => $this->language
            ]);
            $url = 'https://api.worldoftanks.ru/wot/encyclopedia/' . $item . '/?' . $params;
            $responce = $this->requestHttp($url);
            $str = str_replace('http:', 'https:', $responce);
            if (isset($this->pretty)) {
                $str = $this->pretty($str);
            }
            if (isset($this->stdout)) {
                $this->stdout($str);
            }
            file_put_contents($path . $item . '.json', $str);
        }
        return 0;
    }

    /**
     * @return int
     */
    private function getItem($itemName) {
        $params = http_build_query([
            'application_id' => Yii::$app->params['appId'],
            'language' => $this->language
        ]);
        $url = 'https://api.worldoftanks.ru/wot/encyclopedia/' . $itemName . '/?' . $params;
        $responce = $this->requestHttp($url);
        $str = str_replace('http:', 'https:', $responce);
        $path = dirname(__FILE__) . '/../data/';
        if (isset($this->pretty)) {
            $str = $this->pretty($str);
        }
        if (isset($this->stdout)) {
            $this->stdout($str);
        }
        file_put_contents($path . $this->item . '.json', $str);
        return 0;
    }

    /**
     * @param string $url
     * @param string $method
     * @return string
     */
    private function requestHttp($url, $method = 'POST') {
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
