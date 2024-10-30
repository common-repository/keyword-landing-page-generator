<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="support">
	<div class="form-wrapper">
		<h3>FAQ</h3>
		<h3><?php _e( 'I chose a Landing Page from the General Settings, but it\'s not working, what should I do?', 'wpsos-klpg' ); ?></h3>
		<p><?php _e( 'Make sure that you:', 'wpsos-klpg' ); ?></p>
		<ul>
			<li>- <?php _e( 'added the shortcodes to the page content.', 'wpsos-klpg' ); ?></li>
			<li>- <?php _e( 'added a Triggering Keyword to the URL when testing. For example if you have a keyword \'blue\', then try', 'wpsos-klpg' ); ?> <?php echo home_url(); ?>/your-landing-page/blue</li>
			<li>- <?php _e( 'have chosen the option \'Post Name\' under Common Settings of the', 'wpsos-klpg' ); ?> <a href="options-permalink.php">Permalinks settings</a></li>
		</ul>
		<p><?php _e( 'If this is all done, flush the permalinks by going to the', 'wpsos-klpg' ); ?> <a href="options-permalink.php">Permalinks settings</a> <?php _e( 'and clicking', 'wpsos-klpg' ); ?> 'Save'.</p>
		<h3><?php _e( 'The shortcodes worked, but after I changed the Landing Page\'s name and slug, they stopped working.', 'wpsos-klpg' ); ?></h3>
		<p><?php _e( 'Please flush the permalinks by going to the', 'wpsos-klpg' ); ?> <a href="options-permalink.php">Permalinks settings</a> <?php _e( 'and clicking', 'wpsos-klpg' ); ?> 'Save'.</p>
	</div>
	<div class="form-wrapper">
		<h3><?php _e( 'I have a question or suggestion, how can I contact you?', 'wpsos-klpg' ); ?></h3>
		<p><?php _e( 'We are happy to receive all your questions, suggestions, and comments from the following link:', 'wpsos-klpg' ); ?> <a href="http://www.wpsos.io/plugin-support/">WPSOS Plugin Support</a> </p>
		<p><?php _e( 'You can expect an answer within 24 hours.', 'wpsos-klpg' ); ?></p>
	</div>
</div>