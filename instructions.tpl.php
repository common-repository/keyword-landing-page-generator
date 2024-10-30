<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="instructions">
	<div class="form-wrapper">
		<p class="subnote"><?php _e( 'Note that adding/removing Triggering Keywords and Shortcode Keys are premium options.', 'wpsos-klpg' ); ?> <a target="_blank" href="http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/"><?php _e( 'Get the plugin now', 'wpsos-klpg' ); ?></a></p>
	</div>
	<div class="form-wrapper">
		<h3><?php _e( 'What is Landing Page Generator for?', 'wpsos-klpg' ); ?></h3>
		<p><?php _e( 'Landing Page Generator can seem overwhelming -- but it\'s not! Once you get the hang of it, it\'s really quite smooth.', 'wpsos-klpg' ); ?></p>
		<p><?php _e( 'The goal of this plugin is to make it easy for you to take one template for a landing page, such as', 'wpsos-klpg' ); ?><?php echo home_url()?>/your-landing-page/ <?php _e( 'and bring in "Triggering Keywords" via the URL, such as this:', 'wpsos-klpg' ); ?> <?php echo home_url(); ?>/your-landing-page/fast/ <?php _e( 'and then, to have content on that landing page change accordingly depending on the Triggering Keyword.', 'wpsos-klpg' ); ?></p>
		<p><?php _e( 'In other words, if you want to have one landing page, but three versions of it: one for people looking for a "cheap" product, one for people looking for the product delivered "fast", and one for people looking for a "high quality" version of the product -- you can now have one page, but actually have three unique pages on Wordpress to drive traffic too, each one customized for that target market.', 'wpsos-klpg' ); ?></p>
	</div>
	<div class="form-wrapper">
		<h3><?php _e( 'How does this magic work? We\'ll step you through it now!', 'wpsos-klpg' ); ?></h3>
		<ol>
			<li><?php _e( 'On the "General settings" tab, choose which page you want to use as the base for the landing page. You can also select the "Insert your custom HTML here" option and use your own. Note that, whether you use a page or your own HTML, you\'ll need to edit it to add in the corresponding shortcodes we will soon create. Don\'t forget to add those in at the appropriate points before it goes live!', 'wpsos-klpg' ); ?>
			<img src="<?php echo plugin_dir_url( WPSOS_KLPG_FILE ); ?>img/general_settings.png" alt="" /></li>
			<li><?php _e( 'Click on the "Keywords" tab, you\'ll see the "Shortcode Key Settings" section. Here, you should create a new Shortcode Key for each unit of text that you would like to change on the landing page for visitors who come to the triggered version. For example, for anyone who comes to one of the pages, if you want the headline to be different, the sub-headline, and and the main image shown to be different -- then, define four shortcode variables here. You can call them anything you like (using the standard alphanumeric characters); just don\'t forget the names!', 'wpsos-klpg' ); ?>
			<img src="<?php echo plugin_dir_url( WPSOS_KLPG_FILE ); ?>img/shortcode-keys.png" alt="" /></li>
			<li><?php _e( 'Scroll halfway down on this page to the "Triggering Keywords" section. You want to create a Triggering Keyword for each separate landing page. The Triggering Keyword will be the phrase in the URL itself. There are a few sample ones created already, but you can create one yourself. If you create a Triggering Keyword called "Blue" just for people searching for your product in blue, then, this will automatically create a page on the site: <?php echo home_url(); ?>/your-landing-page/blue/, using the template that you just set a moment ago during instruction #1. Do the same for each Triggering Keyword you would like to have a unique landing page created for.', 'wpsos-klpg' ); ?>
			<img src="<?php echo plugin_dir_url( WPSOS_KLPG_FILE ); ?>img/triggering-keywords.png" alt="" /></li>
			<li><?php _e( 'For each Triggering Keyword, you will see in this section the Shortcode Keys corresponding to that Triggering Keyword. Just fill them in with the appropriate content you want. So, for example, if you have a Shortcode Key called "headline", and you have a Triggering Keyword "blue", then -- for anyone who goes to <?php echo home_url(); ?>/your-landing-page/blue/, write in here the text they will see for the headline. That\'s it. Note that since it is a Shortcode, you can include text, a URL, or anything that could go into a shortcode.', 'wpsos-klpg' ); ?>
			<img src="<?php echo plugin_dir_url( WPSOS_KLPG_FILE ); ?>img/keyword-values.png" alt="" /></li>
			<li><?php _e( 'Finally, now that you\'ve created a bunch of these shortcodes, don\'t forget to go to the page you\'ve created to for the landing page (or the HTML you inserted, if you chose that option) and to insert the shortcodes at the appropriate sections on the page. If you don\'t do that, then the customized text won\'t appear!', 'wpsos-klpg' ); ?>
			<img src="<?php echo plugin_dir_url( WPSOS_KLPG_FILE ); ?>img/edit-page.png" alt="" /><p>OR</p><img src="<?php echo plugin_dir_url( WPSOS_KLPG_FILE ); ?>img/custom-html.png" alt="" /></li>
			<li><?php _e( 'Test, test, test and get lots of clients from your customized landing pages!', 'wpsos-klpg' ); ?></li>
		</ol> 
	</div>
	<div class="form-wrapper">
		<h3><?php _e( 'Sample content for a landing page', 'wpsos-klpg' ); ?></h3>
		<p><?php _e( 'Here below is a sample content to show how to use the shortcodes on your chosen landing page. Copy this into the page that you selected as a landing page under the "General Settings", and try it out with a keyword!', 'wpsos-klpg' ); ?></p>
		<p><?php _e( 'Note that this works with the shordcode keys that were creating upon installing the plugin (', 'wpsos-klpg' ); ?>"main-heading" <?php _e( 'and', 'wpsos-klpg' ); ?> "content"). <?php _e( 'If you have removed these, please replace the keys with your own!', 'wpsos-klpg' ); ?></p>
		<pre>
		Welcome to the Keyword Landing Page Generator plugin!
		 [wpsos key="main-heading"]
		 [wpsos key="content"]
		Thank you for visiting our page. Please contact us with any questions.
		</pre>
	</div>
</div>