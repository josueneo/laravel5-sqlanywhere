<?php
namespace josueneo\laravel5sqlanywhere;

use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class SQLAnywhereConnector extends Connector implements ConnectorInterface{
    
    public function connect(array $config) {
        //UID=root;PWD=encrypted;ASTOP=no;DBN=raci;DBF=/opt/data/raci.db;HOST=127.0.0.1:2638
        $dsn = $config['dsn']."UID=".$config['username'].";PWD=".$config['password'].";".$config['options'];
        $dsn.= ";DBN=".$config["database"].";DBF=".$config['databasefile'];
        $dsn.= ";HOST=".$config['host'].":".$config['port'];
        $connection = parent::createConnection($dsn, $config, $config);
        return $connection;
    }
    
}
