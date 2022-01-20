<div class="poster rowSerie" id="poster<?php echo $uid; ?>" poster="<?php echo $poster; ?>"
     style="
     display: none;
     background-image: url(<?php echo $global['webSiteRootURL']; ?>plugin/YouPHPFlix2/view/img/loading.gif);
     -webkit-background-size: cover;
     -moz-background-size: cover;
     -o-background-size: cover;
     background-size: cover;
     ">
    <div class="posterDetails " style="
         background: -webkit-linear-gradient(left, rgba(<?php echo $obj->backgroundRGB; ?>,1) 40%, rgba(<?php echo $obj->backgroundRGB; ?>,0) 100%);
         background: -o-linear-gradient(right, rgba(<?php echo $obj->backgroundRGB; ?>,1) 40%, rgba(<?php echo $obj->backgroundRGB; ?>,0) 100%);
         background: linear-gradient(right, rgba(<?php echo $obj->backgroundRGB; ?>,1) 40%, rgba(<?php echo $obj->backgroundRGB; ?>,0) 100%);
         background: -moz-linear-gradient(to right, rgba(<?php echo $obj->backgroundRGB; ?>,1) 40%, rgba(<?php echo $obj->backgroundRGB; ?>,0) 100%);">
        <div class="topicRow">
            <h2 class="infoTitle">
                <?php
                $rowLink = $link = PlayLists::getLink($value['serie_playlists_id']);
                $rowLinkEmbed = $linkEmbed = PlayLists::getLink($value['serie_playlists_id'], true);
                $canWatchPlayButton = "";
                if (User::canWatchVideoWithAds($value['id'])) {
                    $canWatchPlayButton = "canWatchPlayButton";
                } else if ($obj->hidePlayButtonIfCannotWatch) {
                    $canWatchPlayButton = "hidden";
                }
                $value['title'] = "<a href='{$link}' embed='{$linkEmbed}' class='{$canWatchPlayButton}'>{$value['title']}</a>";
                echo $value['title'];
                ?>
            </h2>
            <div class="col-sm-12">
                <?php
                include $global['systemRootPath'] . 'plugin/YouPHPFlix2/view/row_info.php';
                ?>
            </div>
            <div id="ajaxLoad-<?php echo $uid; ?>" class="flickity-area col-sm-12"><?php echo __('Loading...'); ?></div>
        </div>
    </div>

</div>