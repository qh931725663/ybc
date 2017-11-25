<?php


$account_type="";
$account_sector="";
if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1")
{
    $account_type="档口超级用户";
}
elseif ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="2")
{
    $account_type="工厂";
}
elseif ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="3")
{
    $account_type="卖家";
}
elseif ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4")
{
    if ($_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1")
    {
        $account_type="超级用户";
    }
    elseif ($_SESSION["ERP_ACCOUNT_USER_TYPE"]=="2")
    {
        $account_type="档口用户";
        $account_sector="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理档口： ".$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"];
    }
    elseif ($_SESSION["ERP_ACCOUNT_USER_TYPE"]=="3")
    {
        $account_type="仓库用户";
        $account_sector="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理仓库： ".$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"];
    }
}
?>
<div id="headarea">
    <div id="headmain">
        <div style="float:left; margin-left:2%; padding:9px 0"><a href="/"><img src="/pc/images/myaccount_title.png" width="175" height="35" border="0"></a></div>
        <div style="float:right; margin-top:10px">
            <span style="float:left; margin-left:10px; padding:10px 0; color:#ffffff">
            <?php 
            echo ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4"?"当前登录子账号： ":"当前登录手机号： ").$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户类型： ".$account_type.$account_sector;
            ?>
            </span>
            <?php
            if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1"))
            {
                if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]) and !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]) and !empty($_SESSION["ERP_ACCOUNT_USER_WAREHOUSE_COUNT"]) and ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]+$_SESSION["ERP_ACCOUNT_USER_WAREHOUSE_COUNT"])=="1")
                {
            ?>
                    <span style="float:left; padding:10px 0; color:#ffffff">
            <?php
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理档口： ".$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"];
            ?>
                    </span>
            <?php
                }
                else
                {
                    if ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]+$_SESSION["ERP_ACCOUNT_USER_WAREHOUSE_COUNT"]>"1")
                    {
            ?>
            <span style="float:left; padding:10px 0; color:#ffffff">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;档口仓库切换：
            </span>
            <span style="float:left">
                <span id="select_storemain">
                    <span id="select_storeitem"><span id="select_store_name"><?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"全部" ?></span><span id="select_storearrow"></span></span>
                    <span id="select_storeselect">
                        <div class="listclassblock">
                            <div class="listclassdefault">全部：</div>
                        </div>
                        <div style="float:left; width:90%; display:block">
                            <div class="listclassvalueblock">
                                <div class="listclassvalue" onclick="ChangeDangkouStore('','','','')">全部</div>
                            </div>
                        </div>
                        <div class="listclassblock">
                            <div class="listclassdefault">档口：</div>
                        </div>
                        <div style="float:left; width:90%; display:block">
                            <?php
                            $p=cselect("*","ydf_dangkou",array("dangkou_type='1' and dangkou_endtime>? and dangkou_boss_m_bianhao=?",strtotime(date("Y-m-d H:i:s")),$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao");
                            while ($rowdangkou=$p[0]->fetch())
                            {
                                if ($rowdangkou["dangkou_endtime"]=="0")
                                {
                                    $dangkou_status="11";
                                }
                                elseif ($rowdangkou["dangkou_endtime"]>strtotime(date("Y-m-d H:i:s")))
                                {    
                                    $dangkou_status="12";            
                                }
                                else
                                {
                                    $dangkou_status="13";
                                }
                            ?>
                            <div class="listclassvalueblock">
                                <div class="listclassvalue" onclick="ChangeDangkouStore('<?php echo $rowdangkou["dangkou_type"]?>','<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $dangkou_status?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
                            </div>
                            <?php
                            }
                            ?>
                            
                        </div>
                        <?php
                        $p=cselect("*","ydf_dangkou",array("dangkou_type='2' and dangkou_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao");
                        if ($p[1])
                        {
                        ?>
                        <div class="listclassblock">
                            <div class="listclassdefault">仓库：</div>
                        </div>
                        <div style="float:left; width:90%; display:block">
                        
                            <?php
                            while ($rowstore=$p[0]->fetch())
                            {
                            ?>
                            <div class="listclassvalueblock">
                                <div class="listclassvalue" onclick="ChangeDangkouStore('<?php echo $rowstore["dangkou_type"]?>','<?php echo $rowstore["dangkou_bianhao"]?>','<?php echo $rowstore["dangkou_name"]?>','')"><?php echo $rowstore["dangkou_name"] ?></div>
                            </div>
                            <?php
                            }
                            ?>
                            
                        </div>
                        <?php
                        }
                        ?>
                    </span>
                </span>
            </span>
            <?php
                    }
                }
            }
            ?>
            
            <?php
            if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="2")
            {
                if (!empty($_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]) and !empty($_SESSION["ERP_ACCOUNT_USER_BOSS_COUNT"]) and $_SESSION["ERP_ACCOUNT_USER_BOSS_COUNT"]=="1")
                {
            ?>
                    <span style="float:left; padding:10px 0; color:#ffffff">
            <?php
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合作档口负责人： ".$_SESSION["ERP_ACCOUNT_USER_BOSS_NAME"];
            ?>
                    </span>
            <?php
                }
                else
                {
                    if (!empty($_SESSION["ERP_ACCOUNT_USER_BOSS_COUNT"]) and $_SESSION["ERP_ACCOUNT_USER_BOSS_COUNT"]>"1")
                    {
            ?>
            <span style="float:left; padding:10px 0; color:#ffffff">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合作档口负责人切换：
            </span>
            <span style="float:left">
                <span id="select_storemain">
                    <span id="select_storeitem"><span id="select_store_name"><?php echo !empty($_SESSION["ERP_ACCOUNT_USER_BOSS_NAME"])?$_SESSION["ERP_ACCOUNT_USER_BOSS_NAME"]:"选择" ?></span><span id="select_storearrow"></span></span>
                    <span id="select_storeselect">
                        <div style="float:left; width:100%; display:block">
                            <?php
                            $p=cselect("*","ydf_member",array("m_bianhao in (select factory_boss_m_bianhao from ydf_factory where factory_manage='1' and factory_mobile='".$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"]."')"),"","m_bianhao");
                            while ($rowboss=$p[0]->fetch())
                            {
                            ?>
                            <div class="listclassvalueblock">
                                <div class="listclassvalue" onclick="/**/FactorySelectBoss(<?php echo $rowboss["m_bianhao"]?>)"><?php echo $rowboss["m_realname"] ?></div>
                            </div>
                            <?php
                            }
                            ?>
                            
                        </div>
                    </span>
                </span>
            </span>
            <?php
                    }
                }
            }
            ?>
            <span style="float:left; margin-right:10px; padding:10px 0">
            <?php
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='/logout' class='linktop'>[安全退出]</a>";
            ?>
            </span>
        </div>
    </div>
</div>
