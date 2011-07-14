<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Twig
{
	private $CI;
	private $_twig;
	private $_template_dir;
	private $_cache_dir;

	/**
	 * Constructor
	 * @param bool $debug
	 * @return Twig
	 *
	 */
	function __construct($debug = false)
	{
		$this->CI =& get_instance();
		$this->CI->config->load('twig');
		 
		ini_set('include_path',
		ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries/Twig');
		require_once (string) "Autoloader" . EXT;

		log_message('debug', "Twig Autoloader Loaded");

		Twig_Autoloader::register();

		$this->_template_dir = $this->CI->config->item('template_dir');
		$this->_cache_dir = $this->CI->config->item('cache_dir');

		$loader = new Twig_Loader_Filesystem($this->_template_dir);

		$this->_twig = new Twig_Environment($loader, array(
                'cache' => $this->_cache_dir,
                'debug' => $debug,
		));
		$this->_addCIFormMethods();
	}

	public function add_function($name) 
	{
		$this->_twig->addFunction($name, new Twig_Function_Function($name));
	}

	public function render($template, $data = array()) 
	{
		$template = $this->_twig->loadTemplate($template);
		return $template->render($data);
	}

	public function displayStats($template, $data = array())
	{
		$template = $this->_twig->loadTemplate($template);
		/* elapsed_time and memory_usage */
		$data['elapsed_time'] = $this->CI->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$memory = (!function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2) . 'MB';
		$data['memory_usage'] = $memory;
		$template->display($data);
	}

	public function display($template, $data = array()) {
		$templateObj = $this->_twig->loadTemplate($template);
		$this->CI->output->set_output($templateObj->render($data));
	}

	/**
	 * Added CI From methods from
	 * https://github.com/fritze/codeigniter-twig/blob/master/system/application/libraries/Twig.php
	 * @return void
	 */
	protected function _addCIFormMethods() {
		$this->_twig->addFunction('form_open', new Twig_Function_Function('form_open'));
		$this->_twig->addFunction('form_open_multipart', new Twig_Function_Function('form_open_multipart'));
		$this->_twig->addFunction('form_hidden', new Twig_Function_Function('form_hidden'));
		$this->_twig->addFunction('form_input', new Twig_Function_Function('form_input'));
		$this->_twig->addFunction('form_password', new Twig_Function_Function('form_password'));
		$this->_twig->addFunction('form_upload', new Twig_Function_Function('form_upload'));
		$this->_twig->addFunction('form_textarea', new Twig_Function_Function('form_textarea'));
		$this->_twig->addFunction('form_multiselect', new Twig_Function_Function('form_multiselect'));
		$this->_twig->addFunction('form_fieldset', new Twig_Function_Function('form_fieldset'));
		$this->_twig->addFunction('form_fieldset_close', new Twig_Function_Function('form_fieldset_close'));
		$this->_twig->addFunction('form_checkbox', new Twig_Function_Function('form_checkbox'));
		$this->_twig->addFunction('form_radio', new Twig_Function_Function('form_radio'));
		$this->_twig->addFunction('form_submit', new Twig_Function_Function('form_submit'));
		$this->_twig->addFunction('form_label', new Twig_Function_Function('form_label'));
		$this->_twig->addFunction('form_reset', new Twig_Function_Function('form_reset'));
		$this->_twig->addFunction('form_button', new Twig_Function_Function('form_button'));
		$this->_twig->addFunction('form_close', new Twig_Function_Function('form_close'));
	}
}
