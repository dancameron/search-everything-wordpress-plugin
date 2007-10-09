<?php

Class SearchEverythingAdmin {

	var $version = '4.1';

	function SearchEverythingAdmin() {
	
		// Load language file
		$locale = get_locale();
		if ( !empty($locale) )
			load_textdomain('SearchEverything', SE_ABSPATH .'lang/SE4-'.$locale.'.mo');
	

		add_action('admin_head', array(&$this, 'SE4_options_style'));
		add_action('admin_menu', array(&$this, 'SE4_add_options_panel'));

        }
        
	function SE4_add_options_panel() {
		add_options_page('Search', 'Search Everything', 7, 'manage_search', array(&$this, 'SE4_option_page'));
	}

	//build admin interface
	function SE4_option_page() {
		global $wpdb, $table_prefix;

		if($_POST['action'] == "save") {
			echo "<div class=\"updated fade\" id=\"limitcatsupdatenotice\"><p>" . __("Search Everything Options  <strong>Updated</strong>.") . "</p></div>";

			$new_options = array(
				'SE4_exclude_categories'	=> $_POST["exclude_categories"],
				'SE4_exclude_categories_list'	=> $_POST["exclude_categories_list"],
				'SE4_exclude_posts'		=> $_POST["exclude_posts"],
				'SE4_exclude_posts_list'	=> $_POST["exclude_posts_list"],
				'SE4_use_page_search'		=> $_POST["search_pages"],
				'SE4_use_comment_search'	=> $_POST["search_comments"],
				'SE4_approved_comments_only'	=> $_POST["appvd_comments"],
				'SE4_approved_pages_only'	=> $_POST["appvd_pages"],
				'SE4_use_excerpt_search'	=> $_POST["search_excerpt"],
				'SE4_use_draft_search'		=> $_POST["search_drafts"],
				'SE4_use_attachment_search'	=> $_POST["search_attachments"],
				'SE4_use_metadata_search'	=> $_POST["search_metadata"]
			);

			update_option("SE4_options", $new_options);

		}

		$options = get_option('SE4_options');

		?>
	
		<div class="wrap" id="SE4_options_panel">
			<h2>Search Everything (SE) Version: <?php echo $this->version; ?></h2>
			<p><?php _e('The options selected below will be used in every search query on this site; in addition to the built-in post search.','SearchEverything'); ?></p>
		</div>
	    
		<div class="wrap SE4">
			<h2><?php _e('SE Search Options', 'SearchEverything'); ?></h2>
			<p><?php _e('Use this form to configure your search options.', 'SearchEverything'); ?></p>
			<form method="post">
		    		<fieldset class="options">
		      			<legend><?php _e('Search Options Form', 'SearchEverything'); ?></legend>
		        		<p><input type="checkbox" id="exclude_posts" name="exclude_posts" value="true"  <?php if($options['SE4_exclude_posts'] == 'true') { echo 'checked="true"'; } ?> />
		       			<label for="exclude_posts"><?php _e('Exclude some post or page IDs','SearchEverything'); ?></label><br />
		       			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="exclude_posts_list" class="SE_text_label"><?php _e('Comma separated Post IDs (example: 1, 5, 9)','SearchEverything'); ?></label><br />
		        		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="50" class="SE_text_input" id="exclude_posts_list" name="exclude_posts_list" value="<?php echo $options['SE4_exclude_posts_list'];?>" /></p>
	
		        		<p><input type="checkbox" id="exclude_categories" name="exclude_categories" 
					value="true"  <?php if($options['SE4_exclude_categories'] == 'true') { echo 'checked="true"'; } ?> /> 
		       			<label for="exclude_categories"><?php _e('Exclude Categories <strong><small>(Wordpress 2.2 Only)</strong></small>','SearchEverything'); ?></label><br />
		       			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="exclude_categories_list" class="SE_text_label"><?php _e('Comma separated category IDs (example: 1, 4)','SearchEverything'); ?></label><br />
		         		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="50" class="SE_text_input" id="exclude_categories_list" name="exclude_categories_list" value="<?php echo $options['SE4_exclude_categories_list'];?>" /></p>
		
		         		<p><input type="checkbox" id="search_pages" name="search_pages"
					value="true"  <?php if($options['SE4_use_page_search'] == 'true') { echo 'checked="true"'; } ?>  />
		       			<label for="search_pages"><?php _e('Search every page (non-password protected)','SearchEverything'); ?></label></p>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="SE_text_input" id="appvd_pages" name="appvd_pages" value="true"  <?php if($options['SE4_approved_pages_only'] == 'true') { echo 'checked="true"'; } ?>
		      			<label for="appvd_pages"><?php _e('Search approved pages only?','SearchEverything'); ?></label></p>
		
		         		<p><input type="checkbox" id="search_comments" name="search_comments" 
					value="true"  <?php if($options['SE4_use_comment_search'] == 'true') { echo 'checked="true"'; } ?> />
		       			<label for="search_comments"><?php _e('Search every comment','SearchEverything'); ?></label></p>
		          
				 	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="SE_text_input" id="appvd_comments" name="appvd_comments" value="true"  <?php if($options['SE4_approved_comments_only'] == 'true') { echo 'checked="true"'; } ?>
		       			<label for="appvd_comments"><?php _e('Search approved comments only?','SearchEverything'); ?></label></p>
		
		         		<p><input type="checkbox" id="search_excerpt" name="search_excerpt" value="true"  <?php if($options['SE4_use_excerpt_search'] == 'true') { echo 'checked="true"'; } ?> />
		       			<label for="search_excerpt"><?php _e('Search every excerpt','SearchEverything'); ?></label></p>
		
		         		<p><input type="checkbox" id="search_drafts" name="search_drafts" value="true"  <?php if($options['SE4_use_draft_search'] == 'true') { echo 'checked="true"'; } ?> 
		       			<label for="search_drafts"><?php _e('Search every draft','SearchEverything'); ?></label></p>
		
		         		<p><input type="checkbox" id="search_attachments" name="search_attachments" value="true"  <?php if($options['SE4_use_attachment_search'] == 'true') { echo 'checked="true"'; } ?> />
		       			<label for="search_attachments"><?php _e('Search every attachment','SearchEverything'); ?></label></p>
		
		         		<p><input type="checkbox" id="search_metadata" name="search_metadata" value="true"  <?php if($options['SE4_use_metadata_search'] == 'true') { echo 'checked="true"'; } ?> />
		       			<label for="search_metadata"><?php _e('Search every custom field (metadata)','SearchEverything'); ?></label></p>
		
		   		</fieldset>
				<fieldset class="options">
					<div class="submit">
						<input type="hidden" name="action" value="save" />
						<input type="submit" value="<?php _e('Update Options', 'SearchEverything') ?>" />
					</div>
				</fieldset>
		    	</form>
		</div>
		<div class="wrap SE4">
			<h2><?php _e('SE Search Form', 'SearchEverything'); ?></h2>
			<p><?php _e('Use this search form to run a live search test.', 'SearchEverything'); ?></p>
			 
		      	<fieldset>
		       		<legend><?php _e('Site Search', 'SearchEverything'); ?></legend>
		        	<form method="get" id="searchform" action="<?php bloginfo('home'); ?>"><p class="srch submit">
					<label for="s"><?php _e('Enter search terms', 'SearchEverything'); ?><br /></label>
		          		<input type="text" class="srch-txt" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
				  	<input type="submit" class="SE4_btn" id="searchsubmit" value="<?php _e('Run Test Search', 'SearchEverything'); ?>" /></p>
		      		</form>
			</fieldset>
		</div>
		<div class="wrap">
			<h2>SE Project Information</h2>
		       	<p>The development since Version One has primarily come from the WordPress community and as a Search Everything user myself, I&#8217;m grateful for their dedicated and continued support:</p>
		        <ul class="SE_lists">
					<li>Alakhnor</li>
					<li><a href="http://kinrowan.net/">Cori Schlegel</a></li>
					<li><a href="http://green-beast.com/">Mike Cherim</a></li>
		        	<li><a href="http://blog.saddey.net/">Saddy</a></li>
		        	<li><a href="http://www.reaper-x.com/">Reaper</a></li>
					<li><a href="http://http://beyn.org/">Barış Ünver</a> (localization support)</li>
		        	<li>Uli Iserloh</li>
		        </ul>
			<p>If you&#8217;d like to contribute there&#8217;s a lot to do:</p>
		        <ul class="SE_lists">
				<li><strong>Category Exclusion for new 2.3 Taxonomy Schema</strong></li>
				<li>More meta data functions.</li>
		        	<li>Searching tags (WP 2.3).</li>
				<li>Search Bookmarks.</li>
				<li>&#8230;anything else you want to add.</li>
		        </ul>
		        <br/><p>The current project home is at <a href="http://scatter3d.com/">scatter3d.com</a>. If you want to contribute <a href="mailto:dancameron@gmail.com">e-mail me</a> your modifications.<br/> Donations are accepted.</p>
			<p class="sig">Respectfully,<br />
			<a href="http://dancameron.org/">Dan Cameron</a></p>
		</div>
		
		<?php
	}	//end SE4_option_page

	//styling options page
	function SE4_options_style() {
		?>
		<style type="text/css" media="screen">
			div.SE4 p.submit, div.SE4 form p.submit, div.SE4 p.submit input { text-align:left; } 
			#SE4_options_panel p.submit { text-align:left; }
		  	form#searchform label, form#searchform input, form#SE_form label, form#SE_form input { margin-left:10px; }
		  	input.SE4_btn { cursor:pointer; margin-left:5px; }
		  	p.srch { margin:0; margin-bottom:20px; } 
		  	p.submit input.srch-txt { background-color:#f4f4f4; background-image:none; border:1px solid #999; padding:6px; }
		  	p.submit input.srch-txt:focus, p.submit input.srch-txt:active { background-color:#fff; background-image:none; border:1px solid #111; padding:6px; }
		  	p.sig { margin-left:25px; }
		  	span.SE_notice { color:#cd0000; font-weight:bold; padding-left:10px; }
			label.SE_text_label { cursor:text; } 
			form#SE_form label.SE_text_label, form#SE_form input.SE_text_input { margin-left:38px; }
			ul.SE_lists li { list-style-type:square; }
		</style>
		<?php
	}

}
?>