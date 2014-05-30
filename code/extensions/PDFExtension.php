<?php

/**
 * PDFExtension
 * Facilitate the generation of an SSViewer rendered PDF.
 * @author Will Morgan <@willmorgan>
 */
class PDFExtension extends DataExtension {

	/**
	 * @var string Absolute path to the wkhtmltopdf binary
	 */
	static private $wkhtmltopdf_binary = null;

	/**
	 * @var string 	As the page is generated on the server, the public facing host
	 * 				will typically not be accessible, and instead be localhost.
	 */
	static private $render_host = 'http://localhost/';

	/**
	 * @return string
	 */
	static public function get_wkhtmltopdf_binary() {
		return static::config()->get('wkhtmltopdf_binary');
	}

	/**
	 * @return string
	 */
	static public function get_render_host() {
		return static::config()->get('render_host');
	}

	/**
	 * @return Config_ForClass
	 */
	static public function config() {
		return Config::inst()->forClass(get_called_class());
	}

	/**
	 * The template to use to render this PDF. The owner object can override this.
	 * @return string
	 */
	public function getPDFTemplate() {
		return sprintf("%s_pdf", $this->owner->class);
	}

	/**
	 * Render the object using SSViewer
	 * @return string
	 */
	public function forPDF($variables = array()) {
		Config::nest();
		Config::inst()->update('Director', 'alternate_base_url', static::get_render_host());
		$file = $this->owner->getPDFTemplate();
		$viewer = new SSViewer($file);
		$output = $viewer->process($this->owner, $variables);
		Config::unnest();
		return $output;
	}

	/**
	 * @param array $userOptions See \Knp\Snappy\Pdf->configure
	 * @param array $variables Variables for use in SSViewer
	 * @return string PDF file
	 */
	public function generatePDF($userOptions = array(), $variables = array()) {
		require_once BASE_PATH . '/vendor/autoload.php';
		$defaults = array(
			'enable-javascript' => false,
		);
		$output = $this->forPDF();
		$snappy = new \Knp\Snappy\Pdf(static::get_wkhtmltopdf_binary());
		return $snappy->getOutputFromHTML($this->forPDF($variables), array_merge($defaults, $userOptions));
	}

}
