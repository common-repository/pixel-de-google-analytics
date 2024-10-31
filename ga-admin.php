<?php
if(!defined('ABSPATH')) exit;

add_action( 'admin_menu', 'pga_universal_menu');

function pga_universal_menu() {
	add_options_page('Google Analytics by Lab School', 'Google Analytics','manage_options', 'google-analytics', 'pga_universal_conf');
}

function pga_universal_conf() {
?>
	
<style>
#wrap{margin:0; padding:0;}
#col1{width:600px;float:left;text-align:left;padding:0 0 0 10px; margin: 0 10px 0 0}
#col2{width:170px;float:left;text-align:right;padding:0 10px 0 0}
#col3{width:790px;clear:both; margin:20px 0;border-bottom:1px solid #ccc;font-size:20px;padding:0 0 10px 10px}
#guardar{width:800px;clear:both; margin:20px 0}
.instruccion{ font-style:italic; font-size:13px;color:#888; margin:12px 0 0 0}

@media screen and (max-width: 899px) {
#col1{width:500px}
#col2{width:170px}
#col3{width:690px}
#guardar{width:700px}
}

@media screen and (max-width: 767px) {
#col1{width:450px}
#col2{width:170px}
#col3{width:640px}
#guardar{width:650px}
}

@media screen and (max-width: 479px) {
#col1{width:170px}
#col2{width:150px}
#col3{width:340px}
#guardar{width:350px}
}
</style>

<div class="wrap">	
<h2>Google Analytics by Lab School</h2>
<form method="post" action='options.php' id="guardar">
	<?php settings_fields('pga_universal_options'); ?>
	<?php do_settings_sections('ga_universal'); ?>
<input class="button-primary" type="submit" name="submit" value="Guardar cambios" style="margin:20px 0 0 20px"/>
</form>
</div>
 
<?php
}

add_action('admin_init', 'pga_universal_admin_init');

function pga_universal_admin_init() {
	register_setting('pga_universal_options','pga_universal_options','pga_universal_validate');
	add_settings_section('pga_universal_main','', 'pga_universal_section_text','ga_universal');
	add_settings_field('pga_universal_ua_', '','pga_universal_conf_ua_input','ga_universal','pga_universal_main');
	add_settings_field('pga_universal_inc', '','pga_universal_conf_inc_input','ga_universal','pga_universal_main');
	add_settings_field('pga_universal_ano', '','pga_universal_conf_ano_input','ga_universal','pga_universal_main');
	add_settings_field('pga_universal_lin', '','pga_universal_conf_lin_input','ga_universal','pga_universal_main');
	add_settings_field('pga_universal_dis', '','pga_universal_conf_dis_input','ga_universal','pga_universal_main');
}

/* DOCUMENTACION */
function pga_universal_section_text() {
	//echo "<br><a style='margin-left:8px;' href='#'>Documentaci&oacute;n del plugin</a>";
}

/* UA GOOGLE ANALYTICS */
function pga_universal_conf_ua_input() {
	$options = get_option('pga_universal_options');
	$id = $options['id'];
	echo "<div id='col3'>".esc_html('Configuraci&oacute;n B&aacute;sica', 'pga_universal')."</div>";
	echo "<div id='col1'><label>". esc_html('ID de Seguimiento', 'pga_universal') ."</label>
		  <div class='instruccion'>". esc_html('Introduce el c&oacute;digo UA facilitado por Google Analytics', 'pga_universal') ." <a href='https://support.google.com/analytics/answer/1032385?hl=es' target='_blank' rel='nooperner'>". esc_html__('&iquest;C&oacute;mo obtener el UA?', 'pga_universal') ."</a></div></div>";
	echo "<div id='col2'><input id='id' name='pga_universal_options[id]' type='text' value='$id' /></div>";
}

/* INCLUIR CODIGO SEGUIMIENTO */
function pga_universal_conf_inc_input() {
	$options = get_option('pga_universal_options');
	$id = $options['include_snippet_ga'];
	echo "<div id='col1'><label>".esc_html('Agregar c&oacute;digo seguimiento de Google Analytics', 'pga_universal')."</label><br />
		  <div class='instruccion'>".esc_html('Debes marcar esta opci&oacute;n para implementar el c&oacute;digo de seguimiento b&aacute;sico de Google Analytics en toda la web.', 'pga_universal')."</div></div>";
	echo "<div id='col2'><input name='pga_universal_options[include_snippet_ga]' type='checkbox' value='1' ".checked($id,1,false)."/></div>";
}

/* ANONIMIZAR IP */
function pga_universal_conf_ano_input() {
	$options = get_option('pga_universal_options');
	$id = $options['anonymizeip'];
	echo "<div id='col3'>".esc_html('Configuraci&oacute;n Avanzada', 'pga_universal')."</div>";
	echo "<div id='col1'><label>".esc_html('Anonimizar IP', 'pga_universal')."</label>
		  <div class='instruccion'>".esc_html('Marca esta opci&oacute;n si deseas que las direcciones IP de los usuarios permanezcan an&oacute;nimas dentro de los informes de Google Analytics.', 'pga_universal')."</div></div>";
	echo "<div id='col2'><input name='pga_universal_options[anonymizeip]' type='checkbox' value='1' ".checked($id,1,false)."/></div>";
}

/* ATRIBUCION ENLACES MEJORADA */
function pga_universal_conf_lin_input() {
	$options = get_option('pga_universal_options');
	$id = $options['linkid'];
	echo "<div id='col1'><label>".esc_html('Utilizar la atribuci&oacute;n de enlace mejorada', 'pga_universal')."</label>
	      <div class='instruccion'>".esc_html('Marca esta opci&oacute;n para implementar la funci&oacute;n de seguimiento de enlaces mejorada en Google Analytics. Recuerda activar esta opci&oacute; en la configuraci&oacute;n de tu propiedad.', 'pga_universal')."</div></div>";
	echo "<div id='col2'><input name='pga_universal_options[linkid]' type='checkbox' value='1' ".checked($id,1,false)."/></div>";
}

/* INFORMES DEMOGRAFICOS */
function pga_universal_conf_dis_input() {
	$options = get_option('pga_universal_options');
	$id = $options['display'];
	echo "<div id='col1'><label>".esc_html('Habilitar los informes de datos demogr&aacute;ficos y de intereses', 'pga_universal')."</label>
		  <div class='instruccion'>".esc_html('Marca esta opci&oacute;n para que los datos demogr&aacute;ficos y de intereses est&eacute;n disponibles en Google Analytics. Recuerda activar esta opci&oacute; en la configuraci&oacute;n de tu propiedad.', 'pga_universal')." <a href='https://www.labschool.es/habilitar-los-informes-demograficos-intereses-google-analytics/' target='_blank' rel='nooperner'>".esc_html('&iquest;Necesitas ayuda?', 'pga_universal')."</a> </div></div>";
	echo "<div id='col2'><input name='pga_universal_options[display]' type='checkbox' value='1' ".checked($id,1,false)."/></div>";
}

/* GUARDAR OPCIONES */
function pga_universal_validate($form){
	$options 						= get_option('pga_universal_options');
	$updated 						= $options;
	$updated['id'] 					= $form['id'];
	$updated['include_snippet_ga'] 	= $form['include_snippet_ga'];
	$updated['anonymizeip']			= $form['anonymizeip'];
	$updated['linkid'] 				= $form['linkid'];
	$updated['display'] 			= $form['display'];
	return $updated;
}

?>
