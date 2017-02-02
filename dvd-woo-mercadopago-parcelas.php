<?php
/**
 * Plugin Name: DVD Woo MercadoPago Parcelas
 * Plugin URI: https://github.com/davidcostadev/dvd-woo-mercadopago-parcelas
 * Description: Parcelamento dos produtos de acordo com os fatores do mercadopago.
 * Author: David Costa
 * Author URI: http://davidcosta.com.br
 * Version: 1.0.0
 * License: GPLv3 or later
 * License URI: //www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: dvd-woo-mercadopago-parcelas
 * Domain Path: /languages
 */


if(!defined('ABSPATH')){
	exit;
}

if ( ! class_exists( 'DVDMercadoParcelas' ) ) :


if ( !defined('DVD_PATH') )
    define('DVD_PATH', dirname(__FILE__) . '/');


final class DVDMercadoParcelas
{
    protected static $_instance = null;

	public $option_name = 'dvdwoo_settings';

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {


        // CP_ApiConfig::init();
        $this->incluir();

		$this->get_settings();

		require DVD_PATH . 'admin.php';
		require DVD_PATH . 'calc-parcelamento.php';

    }

	public function incluir() {

			// add_action('woocommerce_after_shop_loop_item', [$this, 'price_loop_item'], 20);
			add_action('woocommerce_get_price_html', [$this, 'dvd_wrap_price_html'], 50);  //<---
			add_action('woocommerce_single_product_summary', [$this, 'add_table_parcelamento'], 40);
        // if ( !function_exists('media_handle_upload') ) {
        //   require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        //   require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        //   require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        // }

	}

	public function price_loop_item() {
			echo '<div class="teste" style="color: blue; font-size: 18px; ">teste</div>';
	}

	public function dvd_wrap_price_html( $html ) {

		$html = $this->filtrar($html);


		return apply_filters( 'dvd_price_html', $html );
	}

	public function get_settings() {
		$this->settings = get_option($this->option_name);
	}

	private function filtrar($html) {
		global $product;
		//
		// echo '<pre>';
		// print_r($product);
		// echo '</pre>';


		if(!empty($product->sale_price)) {
			$de  = $product->regular_price;
			$por = $product->price;
		} else {
			$de  = null;
			$por = $product->price;
		}
		// $html = str_replace('<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#82;&#36;', '', $html);
		// $html = str_replace('</span>', '', $html);
		// $html = str_replace('&nbsp;', '', $html);
		// $antes = $html;
		// $html = str_replace('.', '', trim($html));
		// $valor = (float) str_replace(',', '.', $html);

		$valor =  (float) $product->price;


		$desconto = $valor * 0.93;

		$inicio = '<span class="dvd-woo-merc-parcelas-price woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">';
		$fim    = '</span></span>';



		$textParcelado = CalcParcelamento::instance()
			->calc($valor);

		if($de) {
			$priceText = '<u>De ' . $this->floatToReal($de) . ' Por</u> <br> <strong>' . $this->floatToReal($por) .'</strong>';//.' <small>À Vista</small></strong>' ;
		} else {
			$priceText = $this->floatToReal($por) ;//.' <small>À Vista</small>' ;
		}

		if($textParcelado) {
			// $textParcelado .= '<br>';
		}


		return $inicio .
			'<span class="valor">'.$priceText.'</span> '.
			// $this->floatToReal($valor).
				'<span class="parcelado">'.$textParcelado.'</span>'.
					'<span class="desconto">ou '.$this->floatToReal($desconto).' Boleto (com 7% DESC)</span>'.

			$fim
		;
	}

	private function floatToReal($float) {
		return 'R$ '. number_format($float, 2, ',', '.');
	}

	public function add_table_parcelamento() {
		global $product;

		// echo '<pre>';
		// print_r($product);
		// echo '</pre>';



		$tableParcelado = CalcParcelamento::instance()
			->parcela_table($product->price);

		// echo plugins_url('img/mercadopago-logo.png');
		echo $tableParcelado;
	}



}

DVDMercadoParcelas::instance();



endif;
