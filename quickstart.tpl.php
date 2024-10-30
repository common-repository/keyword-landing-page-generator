<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="quickstart-wrapper">
	<div id="quickstart">
		<div class="form-wrapper">
			<h3><?php _e( 'Get started in one click!' ); ?></h3>
			<p><?php _e( 'Generate a ready to use sample Keyword Landing Page. You can remove it or change it later as you wish!' ); ?></p>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				<input type="submit" class="submit" name="wpsos_klpg_generate_lp" value="Generate now">
				<input type="submit" name="wpsos_klpg_disable_quickstart" value="<?php _e( 'No, thanks! I know what I\'m doing' ); ?>" />
			</form> 
		</div>
	</div>
</div>