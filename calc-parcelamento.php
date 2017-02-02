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

if ( ! class_exists( 'CalcParcelamento' ) ) :

final class CalcParcelamento
{
    /**
     * 0 - Mercado Livre
     * 1 - Marcedo password_get_info
     * 2 - Sem Juros
     */
	public $fator = 'mercado_livre';
	public $valor_minimo = 10;

    public $mercaro_livre = [
        '2' => 5.24,
        '3' => 6.99,
        '4' => 8.74,
        '5' => 10.28,
        '6' => 11.99,
        '10' => 14.85,
        '12' => 15.99,
        // '15' => 18.49,
        // '18' => 21.49,
        // '24' => 27.99
    ];

    public $mercaro_pago = [
        '2' => 2.39,
        '3' => 4.78,
        '4' => 7.17,
        '5' => 9.15,
        '6' => 10.72,
        '10' => 17.17,
        '12' => 20.48,
        // '15' => 25.56,
        // '18' => 30.77,
        // '24' => 32.99
    ];

    public $sem_juros = [
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 0,
        '5' => 0,
        '6' => 0,
        '7' => 12.308,
        '8' => 13.920,
        '9' => 15.542,
        '10' => 17.170,
        '11' => 18.822,
        '12' => 20.480,
        // '15' => 25.56,
        // '18' => 30.77,
        // '24' => 32.99
    ];

    protected $type = 'sem_juros';

    protected static $_instance  = null;

	// $Calc = self::instance();

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function setType($type) {
        $this->type = $type;
		return $this;
    }

    public function setMinimo($minimo) {
        $this->valor_minimo = $minimo;
		return $this;
    }

    public function calc($valor) {
		if($valor == 0) {
			return '';
		}

		$fators = $this->getFator();

		$last = '';
        foreach ($fators as $divisao => $fator) {
            $fator_refinado  = ($fator * 0.01) + 1;
            $total_parcelado = $valor * $fator_refinado;
            $parcela         = $total_parcelado / $divisao;

			if($parcela < $this->valor_minimo) break;
			if($divisao > 6) break;

				$semJurusText = $fator == 0 ? ' SEM JUROS' : '';

            $last =  'em <strong>'. $divisao .'x de '.$this->floatToReal($parcela).'</strong>'.$semJurusText;
        }

		return $last;
    }

	public function parcela_table($valor) {
		if($valor == 0) {
			return '';
		}

		$fators = $this->getFator();

		$html = '';
        foreach ($fators as $divisao => $fator) {
            $fator_refinado  = ($fator * 0.01) + 1;
            $total_parcelado = $valor * $fator_refinado;
            $parcela         = $total_parcelado / $divisao;

			if($parcela < $this->valor_minimo) break;
			$semJurusText = $fator == 0 ? ' SEM JUROS' : '';
            $html .=  '<div class="col-xs-12 col-sm-6"><strong>'. $divisao .'x de '.$this->floatToReal($parcela).'</strong>'.$semJurusText.'</div>';
        }

		$img = '<img src="'.plugins_url('dvd-woo-mercadopago-parcela/img/bandeiras-parcelamento.gif').'">';


		return '<div id="table-parcelado"><div class="title">'.$img.' Parcelamento</div><div class="row">'.$html.'</div></div>';
	}

	private function getFator() {
		switch ($this->type) {
            case 'mercaro_livre':
                $fators = $this->mercaro_livre;
                break;
            case 'sem_juros':
                $fators = $this->sem_juros;
                break;
            case 'mercaro_pago':
                $fators = $this->mercaro_pago;
                break;
        }

		return $fators;
	}



	private function floatToReal($float) {
		return 'R$ '. number_format($float, 2, ',', '.');
	}

}

// new CalcParcelamento();



endif;
