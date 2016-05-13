<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\ClickServer;

use Piwik\DataTable;
use Piwik\DataTable\Row;
use Piwik\API\Request;
use Piwik\Db;
use Piwik\API\Common as ApiCommon;
use Piwik\Common;

/**
 * API for plugin ClickServer
 *
 * @method static \Piwik\Plugins\ClickServer\API getInstance()
 */
class API extends \Piwik\Plugin\API
{

    /**
     * Another example method that returns a data table.
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    private function getDb()
    {
        return Db::get();
    }
    public function getContadordeAbertura($idSite, $period, $date, $segment = false)
    {
        $table = new DataTable();
        $data = date("d-m-Y", $date);
        $campaign = $this->getDb()->fetchAll("SELECT id FROM ".Common::prefixTable("campaigns")." WHERE idSite = $idSite");
         for($i=0;$i<count($campaign);$i++){
                $opens = $this->getDb()->fetchOne("SELECT COUNT(id_campaigns) FROM ".Common::prefixTable("opens")." WHERE id_campaigns = '".$campaign[$i]['id']."'");
                $clicks = $this->getDb()->fetchOne("SELECT COUNT(id) FROM ".Common::prefixTable("clicks")." WHERE id = '".$campaign[$i]['id']."'");
                $table->addRowFromArray(array(Row::COLUMNS => array(
                             'campaigns' => $campaign[$i]['id'],
                             'data' =>  $data,
                             'opens' => $opens,
                             'clicks' => $clicks,
                             //'conversion'=> '2'
                )));
         }
        return $table;
    }
    
  
    public function getCPM($idSite, $period, $date, $segment = false)
    {
        $table = new DataTable();

        $table->addRowFromArray(array(Row::COLUMNS => array('nb_visits' => 5)));

        return $table;
    }
      public function getCPL($idSite, $period, $date, $segment = false)
    {
        $table = new DataTable();

        $table->addRowFromArray(array(Row::COLUMNS => array('nb_visits' => 5)));

        return $table;
    }
      public function getCPC($idSite, $period, $date, $segment = false)
    {
        $table = new DataTable();

        $table->addRowFromArray(array(Row::COLUMNS => array('nb_visits' => 5)));

        return $table;
    }
    
    public function getConversao($idSite, $period, $date, $segment = false)
    {
        $table = new DataTable();

        $table->addRowFromArray(array(Row::COLUMNS => array('nb_visits' => 5)));

        return $table;
    }
}
