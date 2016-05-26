<?php
class LoggerRendererJSON implements LoggerRenderer {

	/** @inheritdoc */
	public function render($input) {
		return json_encode($input);
	}
}
