<?php

/**
 *
 * @since 		1.0.0
 * @author 		David Costa <contato@davidcosta.com.br>
 * @version 	1.0.0
 */

class DVDMercadoParcelas_admin {

    public $page = 'dvdwoo';

    public $option_group = 'dvdwoo_settings';

    public $option_name = 'dvdwoo_settings';


   public $settings;

    public function __construct() {


        add_action('admin_menu', array($this, 'add_menu'), 100);

        add_action('admin_init', array($this, 'dvdwoo_page_settings'));

		/**
		 * Keep array of settings
		 */
		$this->settings = get_option($this->option_name);
    }

    public function add_menu(){
		add_submenu_page(
			'woocommerce',
			__('DVD Woo Mercadopago Parcelas',	'dvd-woo-mercadopago-parcelas'),
			__('Mercadopago Parcelas', 'dvd-woo-mercadopago-parcelas'),
			apply_filters('dvdwoo_page_view_permission', 'manage_options'),
			$this->page,
			array($this, 'dvdwoo_page_callback')
		);
	}

    public function dvdwoo_page_callback(){
		include_once 'html-settings-page.php';
	}

    public function dvdwoo_page_settings() {


        // add_settings_field(
		// 	'show_sem_juros',
		// 	__('Sem Juros', 'dvd-woo-mercadopago-parcelas'),
		// 	array($this, 'dvdwoo_select_callback'),
		// 	$this->page,
		// 	'section_general-base',
		// 	array(
		// 		'id'		=>	'show_sem_juros',
		// 		'options'	=>	array(
		// 					0	=>	'Ocultar',
		// 					1	=>	'Mostrar',
		// 				),
		// 		'desc'		=>	__('Se quer Mostrar ou Ocultar o texto Sem Juros', 'dvd-woo-mercadopago-parcelas'),
		// 		'default'	=> ''
		// 	)
		// );

		// add_settings_field(
		// 	'desconto',
		// 	__('Valor do Desconto','dvd-woo-mercadopago-parcelas'),
		// 	array($this, 'dvdwoo_number_callback'),
		// 	$this->page,
		// 	'section_general-base',
		// 	array(
		// 		'id'		=>	'desconto',
		// 		'label_for'	=>	'desconto',
		// 		'default'	=>	2,
		// 		'class'		=> '',
		// 		'desc'		=>	__('Se for 0 o desconto não é ativado', 'dvd-woo-mercadopago-parcelas')
		// 	)
		// );
        //
        // add_settings_field(
		// 	'parcelamento_fator',
		// 	__('Fator do Parcelamento', 'dvd-woo-mercadopago-parcelas'),
		// 	array($this, 'dvdwoo_select_callback'),
		// 	$this->page,
		// 	'section_general-base',
		// 	array(
		// 		'id'		=>	'parcelamento_fator',
		// 		'options'	=>	array(
		// 					0	=>	'Marcado Livre',
		// 					1	=>	'Mercado Pago',
		// 					2	=>	'Sem Juros'
		// 				),
		// 		'desc'		=>	__('Tipo do fator de para calcular parcelas', 'dvd-woo-mercadopago-parcelas'),
		// 		'default'	=> ''
		// 	)
		// );

        register_setting(
			$this->option_group,
			$this->option_name,
			array($this, 'dvdwoo_options_sanitize')
		);
    }

    public function dvdwoo_checkbox_callback($args){
		extract($args);

		$value = isset($this->settings[$id]) ? $this->settings[$id] : 0;

		echo "<input type='checkbox' id='".$id."-0' name='".$this->option_name."[$id]' value='1'".checked('1', $value, false)." />";
		echo isset($desc) ? "<span class='description'> $desc</span>" : '';
	}

	public function dvdwoo_text_callback($args){
		extract($args);

		$value = isset($this->settings[$id]) ? $this->settings[$id] : $default;

		echo "<input class='$class' type='text' id='$id' name='".$this->option_name."[$id]' value='$value' placeholder='$placeholder' />";
		echo isset($desc) ? "<br /><span class='description'>$desc</span>" : '';
	}

	public function dvdwoo_number_callback($args){
		extract($args);

		$value = isset($this->settings[$id]) ? $this->settings[$id] : $default;

		echo "<input class='$class' type='number' id='$id' name='".$this->option_name."[$id]' value='$value' />";
		echo isset($desc) ? "<br /><span class='description'>$desc</span>" : '';
	}

	public function dvdwoo_select_callback($args){
		extract($args);

		$value = isset($this->settings[$id]) ? $this->settings[$id] : $default;

		echo "<select name='".$this->option_name."[$id]'>";
		foreach($options as $k => $option){
			echo "<option value='$k'".selected($k, $value, false).">".$option."</option>";
		}
		echo "</select>";
		echo isset($desc) ? "<br /><span class='description'>$desc</span>" : '';
	}

	public function dvdwoo_options_sanitize($input){
		foreach($input as $k => $v){
			if($k == 'installment_qty'){
				// if($v < 2 || empty($v)){
				// 	$v = 2;
				// }
			}
			else if($k == 'installment_minimum_value'){
				// if($v < 0 || empty($v)){
				// 	$v = 0;
				// }
			}

			$newinput[$k] = trim($v);
		}

		return $newinput;
	}
}


new DVDMercadoParcelas_admin();
