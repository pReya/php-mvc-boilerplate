<?php
namespace Controllers;

class GamedayController implements Controller
{
    protected $view;

    public function setView($view)
    {
        $this->view = $view;
    }

    public function indexAction()
    {
        $gamedayParameter = isset($_GET["d"]) ? $_GET["d"] : "";

        $matches = $this->getGameDayMatches($gamedayParameter);

        $this->view->setVars([

            "matches" => $matches,

        ]);
    }

    private function getGameDayMatches($gameDay)
    {

        $baseUrl = \Config::getInstance()->getConfig("apiBaseUrl");
        $leagueSeason = \Config::getInstance()->getConfig("leagueSeason");

        // Not specifying a season and day will deliver results for current game day
        if (empty($gameDay))
        {
            $url = $baseUrl."getmatchdata/bl1/";
        }

        // Get games for a specific game day
        else
        {
            $url = $baseUrl."getmatchdata/bl1/".$leagueSeason."/".(string)$gameDay;
        }

        return $this->sendApiRequest($url);
    }

    private function sendApiRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true);
    }


}