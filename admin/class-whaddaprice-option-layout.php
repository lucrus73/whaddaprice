<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* creo metabox opzioni */

class Whadda_option {

  private $metakeypre;
  private $metakeycol;
  private $metakeyrow;

  function __construct() {
    add_action('add_meta_boxes', array($this, 'metabox_opz'));

    $this->metakeypre = WhaddaMetaKeys::PREFIX;
    $this->metakeycol = WhaddaMetaKeys::NUMBER_OF_COLUMNS;
    $this->metakeyrow = WhaddaMetaKeys::NUMBER_OF_ROWS;
  }

  public function metabox_opz() {
    $id = $this->metakeypre . 'boxidopz';
    $title = __('opzioni', 'whaddaprice');
    $callback = array($this, 'callback_whaddaprice_opz'); //chiamo funzione per contenuto 
    $page = 'whaddaprice';
    add_meta_box($id, $title, $callback, $page);
  }

  /* funzione che gesticsce richiamo funzioni e classi per campo opzioni */

  public function callback_whaddaprice_opz() {

    $this->layout(); // chiama la funzione per la scelta layout
    $whadda_color = new Whadda_color(); // chiama la classe per scelta colori
    $font = new Whadda_font(); // chiama classe per scelta font
    $angoli = new whadda_angle(); // chiama la classe scelta angoli
    $mar_pad = new whadda_marg_pad(); //chiama la classe scelta margin e padding
  }

  /* funzione per la scelta del layuot */

  public function layout() {

    $prefix = $this->metakeypre;
    $whadda_layout = $prefix . 'layout';
    $numlayout = 3;
    for ($i = 1; $i <= $numlayout; $i++) {
      $layout[$i] = plugin_dir_url(__FILE__) . 'img/layout' . $i . '.jpg';
      ${"whadda_layout_$i"} = $prefix . 'layout_' . $i;
      if ($i == 3)
        ${"whadda_layout_val_$i"} = "checked";
      else
        ${"whadda_layout_val_$i"} = "";
    }

    if (get_the_ID() !== null) {

      if (!isset(get_post_meta(get_the_ID(), $whadda_layout)[0]) || get_post_meta(get_the_ID(), $whadda_layout)[0] == "") {
        for ($i = 1; $i <= $numlayout; $i++) {
          if ($i != 3) { // layout di default -> se non selezionato altro seleziono il 3
            ${"whadda_layout_val_$i"} = "";
          } else {
            ${"whadda_layout_val_$i"} = "checked";
          }
        }
      } else {
        for ($i = 1; $i <= $numlayout; $i++) {
          if ($i != get_post_meta(get_the_ID(), $whadda_layout)[0] * 1) {
            ${"whadda_layout_val_$i"} = "";
          } else {
            $prov = get_post_meta(get_the_ID(), $whadda_layout)[0];
            ${"whadda_layout_val_$prov"} = "checked";
          }
        }
      }
    }

    echo '<h3>' . esc_html__('Layout', 'whaddaprice') . '</h3>';
    for ($i = 1; $i <= $numlayout; $i++)
      echo '<label class="labelbordi"><img src="' . $layout[$i] . '"><input class="inputbordi" type="radio" name="' . $whadda_layout . '" id="' . ${"whadda_layout_$i"} . '" value="' . $i . '" ' . ${"whadda_layout_val_$i"} . '></label>';
  }

}