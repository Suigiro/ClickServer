<?php
namespace Piwik\Plugins\ClickServer;
use Piwik\Db;
use Piwik\Common;
use Piwik\View;
use Piwik\API\Request;

class Controller extends \Piwik\Plugin\Controller
{
    private function getDb()
    {
        return Db::get();
    }
     public function setOpens(){          
         
         $emailTarget = Common::getRequestVar('emailHash');
         $campaigns = Common::getRequestVar('c');
         $agent_user = $_SERVER['HTTP_USER_AGENT'];
         $data = date("Y-m-d");
         $session = md5($data);
         $ip = $_SERVER['REMOTE_ADDR'];
         $row1 = array(  
                    "id_campaigns" => $campaigns,
                    "session" => $session,
                    "user_agent" => $agent_user,
                    "ip" => $ip,
                    "hash" => $emailTarget,
                    "data" => $data);         
          try{
              $sql1 = "INSERT INTO ".Common::prefixTable("opens")." (id_campaigns, session, user_agent, ip, hash, data) values ('".$campaigns."', '".$session."', '".$agent_user."', '".$ip."', '".$emailTarget."', '".$data."')";
              $this->getDb()->exec($sql1, $row1);
         }  catch (Exception $e){
            if(!$this->getDb()->isErrNo($e, '1050')){
                throw $e; die;
            }
        }     
    }
    public function SetClicks(){
        $id = Common::getRequestVar('id');
        $checked =(Common::getRequestVar('checked')==1)?:true;false;
        $link = Common::getRequestVar('link');
        $update_at = Common::getRequestVar('update_at');
        $url = $this->getDb()->fetchOne("SELECT link FROM ".Common::prefixTable("links")." WHERE id = '".$link."'");
        
         try{
              $sql2 = "INSERT INTO ".Common::prefixTable("clicks")." (id, checked, link, update_at) values ('".$id."', '".$checked."', '".$link."', '".$update_at."')";
              $this->getDb()->exec($sql2, $row2);
              header('Location: '.$url);
         }  catch (Exception $e){
            if(!Db::get()->isErrNo($e, '1050')){
                throw $e; die;
         };   
      
       }
    }
    //aramazezamento de links
    public function SetLinks(){
       $id = Common::getRequestVar('id');
       $link = Common::getRequestVar('link'); 
       $row3 = array(
           'id' => $id,
           'link' => $link
       );
        try{
              $sql3 = "INSERT INTO ".Common::prefixTable("links")." (id, link) values ('".$id."', '".$link."')";
             $this->getDb()->exec($sql3);
         }  catch (Exception $e){
            if($this->getDb()->isErrNo($e, '1050')){
                throw $e;
                die;
            }
        }       
    }
    //registrar campanhas
    public function SetCampaigns(){
        $id = (string) Common::getRequestVar('campaign');
        $idSite = (int) Common::getRequestVar('idSite');
        $row4 = array(
           'id' => $id,
           'idSite' => $idSite
       );
        try{
              $sql4 = "INSERT INTO ".Common::prefixTable("campaigns")." (id, idSite) values ('".$id."', '".$idSite."')";
             $this->getDb()->exec($sql4);
                      }  catch (Exception $e){
            if(!$this->getDb()->isErrNo($e, '1050')){
                throw $e; die;
            }
        }
        return true;
    }
   
}

