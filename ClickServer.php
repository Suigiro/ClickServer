<?php
namespace Piwik\Plugins\ClickServer;
use Piwik\Db;
use Piwik\Common;
use Exception;
class ClickServer extends \Piwik\Plugin
{
    public function install(){
        try{
            $sql1 = "CREATE TABLE ".Common::prefixTable("campaigns")." (
                    id VARCHAR(255) NOT NULL,
                    idSite int NOT NULL
                    ) DEFAULT CHARACTER SET = utf8";
            Db::exec($sql1);
        }  catch (Exception $e){
            if(!Db::get()->isErrNo($e, '1050')){
                throw $e;
            }
        }
        try{
            $sql2 = "CREATE TABLE ".Common::prefixTable("clicks")." (
                    id VARCHAR(255) NOT NULL, 
                    checked BIT(1),
                    link TEXT,
                    update_at DATETIME) DEFAULT CHARACTER SET = utf8";
            Db::exec($sql2);
        }  catch (Exception $e){
            if(!Db::get()->isErrNo($e, '1050')){
                throw $e;
            }
        }
        try{
            $sql3 = "CREATE TABLE ".Common::prefixTable("links")." (
                    id VARCHAR(255) NOT NULL, 
                    link TEXT
                    ) DEFAULT CHARACTER SET = utf8";
            Db::exec($sql3);
        }  catch (Exception $e){
            if(!Db::get()->isErrNo($e, '1050')){
                throw $e;
            }
        }
        try{
            $sql4 = "CREATE TABLE ".Common::prefixTable("opens")." (
                    id_campaigns VARCHAR(255) NOT NULL, 
                    session TEXT,
                    user_agent TEXT,
                    ip VARCHAR(255),
                    hash VARCHAR(255),
                    data DATETIME
                    ) DEFAULT CHARACTER SET = utf8";
            Db::exec($sql4);
        }  catch (Exception $e){
            if(!Db::get()->isErrNo($e, '1050')){
                throw $e;
            }
        }
    }
    public function uninstall() {
        Db::dropTables(Common::prefixTable('opens'));
        Db::dropTables(Common::prefixTable('links'));
        Db::dropTables(Common::prefixTable('cliks'));
        Db::dropTables(Common::prefixTable('campaigns'));
    }

}
