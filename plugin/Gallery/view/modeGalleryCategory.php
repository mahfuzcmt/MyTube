<?php
global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once '../../../videos/configuration.php';
}
require_once $global['systemRootPath'] . 'plugin/Gallery/functions.php';
require_once $global['systemRootPath'] . 'objects/subscribe.php';
require_once $global['systemRootPath'] . 'objects/category.php';
$obj = AVideoPlugin::getObjectData("Gallery");
$liveobj = AVideoPlugin::getObjectDataIfEnabled("Live");
$_REQUEST['rowCount'] = 2;
$_REQUEST['current'] = getCurrentPage();

$onlySuggested = $obj->CategoriesShowOnlySuggested;
if(!empty(getSearchVar())){
    $onlySuggested = false;
}
$sort = $_POST['sort'];
unset($_POST['sort']);
$categories = Category::getAllCategories(false, true, $onlySuggested);
$total = Category::getTotalCategories(false, true, $onlySuggested);
$totalPages = ceil($total / getRowCount());
$page = getCurrentPage();
if ($totalPages < $page) {
    $page = $totalPages;
}
$link = "{$global['webSiteRootURL']}plugin/Gallery/view/modeGalleryCategory.php?tags_id=" . intval(@$_GET['tagsid']) . "&search=" . htmlentities(urlencode(getSearchVar())) . "&current={page}";

if (empty($categories)) {
    return false;
}
$_REQUEST['current'] = 1;
$_REQUEST['rowCount'] = $obj->CategoriesRowCount;
?>
<div class="categoriesContainerItem">
    <?php
    $timeLogName = TimeLogStart('modeGalleryCategory');
    foreach ($categories as $_cat) {
        $_GET['catName'] = $_cat['clean_name'];
        if (!empty($liveobj) && empty($liveobj->doNotShowLiveOnCategoryList)) {
            $currentCat = $_cat;
            include $global['systemRootPath'] . 'plugin/Gallery/view/modeGalleryCategoryLive.php';
        }
        unset($_POST['sort']);
        $_POST['sort']['v.created'] = "DESC";
        $_POST['sort']['likes'] = "DESC";
        $videos = Video::getAllVideos("viewableNotUnlisted", false, !$obj->hidePrivateVideos);
        if (empty($videos)) {
            continue;
        }
        if (empty($_cat['clean_name'])) {
            continue;
        }
        ?>
        <div class="clear clearfix">
            <?php
            if (canPrintCategoryTitle($_cat['name'])) {
                ?>
                <h3 class="galleryTitle">
                    <a class="btn-default" href="<?php echo $global['webSiteRootURL']; ?>cat/<?php echo $_cat['clean_name']; ?>">
                        <i class="<?php echo $_cat['iconClass']; ?>"></i> <?php echo $_cat['name']; ?>
                    </a>
                </h3>
                <?php
            }
            createGallerySection($videos, "", array(), true);
            ?>
        </div>

        <?php
    }
    TimeLogEnd($timeLogName, __LINE__, 1);
    ?>
</div>
<!-- modeGalleryCategory -->
<div class="col-sm-12" style="z-index: 1;">
    <?php
    //getPagination($total, $page = 0, $link = "", $maxVisible = 10, $infinityScrollGetFromSelector="", $infinityScrollAppendIntoSelector="")
    echo getPagination($totalPages, $page, $link, 10, ".categoriesContainerItem", ".categoriesContainerItem");
    ?>
</div>
<?php
$_POST['sort'] = $sort;
?>