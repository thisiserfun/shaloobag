<?php
/**
 * Useful functions
 *
 * @package YITH_Proteo_tookit
 */

/**
 * Display a navigation bar in setup wizard box
 *
 * @param string $step Current active step.
 * @return void
 */
function yith_proteo_toolkit_wizard_step_icon( $step = null ) {
	?>
	<div class="yith-proteo-toolkit-wizard-nav">
		<ul class="steps">
			<li class="step <?php echo 'child' === $step ? 'active' : ''; ?>">
				<img src="<?php echo esc_url( YITH_PROTEO_TOOLKIT_URL ); ?>/assets/img/child-theme.svg" width="30">
			</li>
			<li class="step <?php echo 'plugins' === $step ? 'active' : ''; ?>">
				<img src="<?php echo esc_url( YITH_PROTEO_TOOLKIT_URL ); ?>/assets/img/plugin.svg" width="30">
			</li>
			<li class="step <?php echo 'content' === $step ? 'active' : ''; ?>">
				<img src="<?php echo esc_url( YITH_PROTEO_TOOLKIT_URL ); ?>/assets/img/content.svg" width="30">
			</li>
			<li class="step <?php echo 'done' === $step ? 'active' : ''; ?>">
				<img src="<?php echo esc_url( YITH_PROTEO_TOOLKIT_URL ); ?>/assets/img/done.svg" width="30">
			</li>
		</ul>
	</div>
	<?php
}
