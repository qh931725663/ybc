<?php
    include_once("{$root_path}/model/model_bi.php");
    $historys=array();
    $historys_idx=array();
    $factory_bank=array();
    $addup=array();
    get_history_agent_pools("month",$_REQUEST["var_factory_id"],$historys,$historys_idx,$addup);
    $cash_available=sum_addup($addup);
    $factory_bank=array();
    $factory_bank[0][]=$cash_available;

    $p = cselect("*","ydf_factory",array("factory_bianhao=?",$_REQUEST["var_factory_id"]));
    if ($rowfactory=$p[0]->fetch())
    {
        $p = cselect("*","ydf_member",array("m_mobile=?",$rowfactory["factory_mobile"]));
        if ($rowfactorymember=$p[0]->fetch())
        {
            $p = cselect("bank_boss_id,bank_name,bank_user_account,bank_user_name","ydf_bank",array("bank_boss_id=?",$rowfactorymember["m_bianhao"]));
            while ($row=$p[0]->fetch()){
                foreach($row as $row_p=>$value){
                    $factory_bank[$row_p][]=$value;
                }


            }
        }
    }
echo json_encode($factory_bank);
?>