<div class="fullSlide">
    <div class="bd">
        <ul>
            <?php
            if ($_REQUEST["var_opt_id"]=="xszb")
            {
            ?>
            <li _src="url(/pc/images/optplay/xszb/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/xszb/002.jpg)"></li>
            <li _src="url(/pc/images/optplay/xszb/003.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="sdch")
            {
            ?>
            <li _src="url(/pc/images/optplay/sdch/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/sdch/002.jpg)"></li>
            <li _src="url(/pc/images/optplay/sdch/003.jpg)"></li>
            <li _src="url(/pc/images/optplay/sdch/004.jpg)"></li>
            <li _src="url(/pc/images/optplay/sdch/005.jpg)"></li>
            <li _src="url(/pc/images/optplay/sdch/006.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="xsgl")
            {
            ?>
            <li _src="url(/pc/images/optplay/xsgl/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/xsgl/002.jpg)"></li>
            <li _src="url(/pc/images/optplay/xsgl/003.jpg)"></li>
            <li _src="url(/pc/images/optplay/xsgl/004.jpg)"></li>
            <li _src="url(/pc/images/optplay/xsgl/005.jpg)"></li>
            <li _src="url(/pc/images/optplay/xsgl/006.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="kcgl")
            {
            ?>
            <li _src="url(/pc/images/optplay/kcgl/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/kcgl/002.jpg)"></li>
            <li _src="url(/pc/images/optplay/kcgl/003.jpg)"></li>
            <li _src="url(/pc/images/optplay/kcgl/004.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="gccg")
            {
            ?>
            <li _src="url(/pc/images/optplay/gccg/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/gccg/002.jpg)"></li>
            <li _src="url(/pc/images/optplay/gccg/003.jpg)"></li>
            <li _src="url(/pc/images/optplay/gccg/004.jpg)"></li>
            <li _src="url(/pc/images/optplay/gccg/005.jpg)"></li>
            <li _src="url(/pc/images/optplay/gccg/006.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="cwgl")
            {
            ?>
            <li _src="url(/pc/images/optplay/cwgl/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/cwgl/002.jpg)"></li>
            <li _src="url(/pc/images/optplay/cwgl/003.jpg)"></li>
            <li _src="url(/pc/images/optplay/cwgl/004.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="spsz")
            {
            ?>
            <li _src="url(/pc/images/optplay/spsz/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/spsz/002.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="mjsz")
            {
            ?>
            <li _src="url(/pc/images/optplay/mjsz/001.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="gcsz")
            {
            ?>
            <li _src="url(/pc/images/optplay/gcsz/001.jpg)"></li>
            <?php
            }
            elseif ($_REQUEST["var_opt_id"]=="jbsz")
            {
            ?>
            <li _src="url(/pc/images/optplay/jbsz/001.jpg)"></li>
            <li _src="url(/pc/images/optplay/jbsz/002.jpg)"></li>
            <li _src="url(/pc/images/optplay/jbsz/003.jpg)"></li>
            <li _src="url(/pc/images/optplay/jbsz/004.jpg)"></li>
            <li _src="url(/pc/images/optplay/jbsz/005.jpg)"></li>
            <li _src="url(/pc/images/optplay/jbsz/006.jpg)"></li>
            <li _src="url(/pc/images/optplay/jbsz/007.jpg)"></li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="hd"><ul></ul></div>
    <span class="prev"></span>
    <span class="next"></span>
</div>
<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});
$(".fullSlide").slide({
    titCell: ".hd ul",
    mainCell: ".bd ul",
    effect: "fold",
    autoPlay: true,
    autoPage: true,
    trigger: "click",
    startFun: function(i) {
        var curLi = jQuery(".fullSlide .bd li").eq(i);
        if ( !! curLi.attr("_src")) {
            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
        }
    }
});
</script>