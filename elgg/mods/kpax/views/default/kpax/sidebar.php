<?php
/**
 * kpax sidebar
 */
if ($vars['template'] == "list") {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'kpax',
		'owner_guid' => elgg_get_page_owner_guid(),
	));

	echo elgg_view('page/elements/tagcloud_block', array(
		'subtypes' => 'kpax',
		'owner_guid' => elgg_get_page_owner_guid(),
	));
} else if($vars['template'] == "detail") {
	?>
	<div class="elgg-module elgg-module-aside">
	    <div class="elgg-head">
	        <h3>Developer</h3>
	    </div>
	    <div class="elgg-body">
	    	<p><?php echo $vars['user']->name ?></p>
	    </div>
	</div>

	<?php
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'kpax',
		'owner_guid' => elgg_get_page_owner_guid(),
	));
	?>

	<div class="elgg-module elgg-module-aside">
	    <div class="elgg-head">
	        <h3>Game Tags</h3>
	    </div>
	    <div class="elgg-body">
	    	<p>
	    	<?php
			if (count($vars['tagsList'])>0){
        		for ($n = 0; $n < count($vars['tagsList']); $n++)
                	echo $vars['tagsList'][$n]->tag . ', ';
            	echo'</p>';
    		}else
	        	echo'<p>No comments</p>';
	    echo'</div>';
	echo'</div>';
}
