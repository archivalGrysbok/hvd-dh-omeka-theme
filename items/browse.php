<?php
if ($pageTitle = get_theme_option("Browse Item Title")) {
 #$browseNeatlineTitle is set
} else {
 $pageTitle = "Browse Items";
}
echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

<h1><?php echo $pageTitle;?> <?php echo __('(%s total)', $total_results); ?></h1>

<nav class="items-nav navigation secondary-nav">
    <?php echo public_nav_items(); ?>
</nav>

<?php echo item_search_filters(); ?>

<?php echo pagination_links(); ?>

<?php if ($total_results > 0): ?>

<?php
$sortLinks[__('Title')] = 'Dublin Core,Title';
$sortLinks[__('Creator')] = 'Dublin Core,Creator';
$sortLinks[__('Date Added')] = 'added';
?>
<div id="sort-links">
    <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
</div>

<?php endif; ?>

<?php #echo $select; ?>

<?php foreach (loop('items') as $item): ?>
<div class="item record">
    <div class="item-meta-title">
        <h2><?php echo link_to_item(metadata('item', array('Dublin Core', 'Title')), array('class'=>'permalink')); ?></h2>
        <p><em><a href="<?php echo absolute_url(); 
        if (empty($_GET)): 
            echo "?type=";
        else:
            echo "&type=";
        endif;
        echo $item->item_type_id;?>">
        <?php echo metadata('item','item_type_name'); ?></a></em></p>
    </div>
    <div class="item-meta">
    <?php if (metadata('item', 'has thumbnail')): ?>
    <div class="item-img">
        <?php echo link_to_item(item_image('fullsize')); ?>
    </div>
    <?php endif; ?>

    <?php if ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>250))): ?>

    <?php if ($itemAttribution = get_theme_option('Item Attribution')) { ?>
    <div id="item-attribution">
    <?php
      $itemOwnerName = dh_get_user_by_id($item['owner_id'])['name'];
      $itemAttrLabel = get_theme_option('Item Attribution Label');
      echo("$itemAttrLabel $itemOwnerName");
    ?>
    </div>
    <?php } ?>

    <div class="item-description">
        <?php echo $description; ?>
    </div>
    <?php endif; ?>

    <?php if (metadata('item', 'has tags')): ?>
    <div class="tags"><p><strong><?php echo __('Tags'); ?>:</strong>
        <?php echo tag_string('items'); ?></p>
    </div>
    <?php endif; ?>

    <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>

    </div><!-- end class="item-meta" -->
</div><!-- end class="item hentry" -->
<?php endforeach; ?>

<?php echo pagination_links(); ?>

<div id="outputs">
    <span class="outputs-label"><?php echo __('Output Formats'); ?></span>
    <?php echo output_format_list(false); ?>
</div>

<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

<?php echo foot(); ?>
