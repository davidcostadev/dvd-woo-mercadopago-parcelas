<?php
/**
 *
 * @since 		1.0.0
 * @author 		David Costa <contato@davidcosta.com.br>
 * @version 	1.0.0
 */
if(!defined('ABSPATH')){
	exit;
}
?>

<div class="wrap dvd-woo-mercadopago-parcelas">
	<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

	<?php /*<form action="options.php" method="post">
		<?php settings_fields($this->option_group); ?>

		<div class="tabs">
			<div class="section">
				<h3><?php echo __('Opções para parcelamento', 'dvd-woo-mercadopago-parcelas'); ?></h3>
				<table class="form-table">
					<?php do_settings_fields($this->page, 'section_general-base'); ?>
				</table>
			</div>

		</div>

		<?php submit_button(); ?>
	</form> */ ?>

	<div class="section">

		<?php echo '<a class="button-secondary" href="https://github.com/davidcostadev/dvd-woo-mercadopago-parcelas/issues" target="_blank">' . __('Bugs e Sugestões', 'dvd-woo-mercadopago-parcelas') . '</a>'; ?>
		<?php echo '<a class="button-secondary" href="https://github.com/davidcostadev/dvd-woo-mercadopago-parcelas" target="_blank">' . __('Github', 'dvd-woo-mercadopago-parcelas') . '</a>'; ?>
	</div>

</div>
