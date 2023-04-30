<?php

namespace Blogger;

use ErrorException;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * summary
 */
class ContentsReader extends Component
{
	const ENTRY_TERM_POST = 'http://schemas.google.com/blogger/2008/kind#post';

	public string $filePath;
	public array $fileContents;

	function init()
	{
		if (!file_exists($this->filePath) || !is_file($this->filePath)) {
			throw new ErrorException('File not found.');
		}

		$contents = simplexml_load_file($this->filePath);
		if ($contents === false) throw new ErrorException("File \"{$this->filePath}\" is broken.");

		$this->fileContents = json_decode(json_encode($contents), true);
	}

	function entries($entry_term_ = null)
	{
		$entries = ArrayHelper::getValue($this->fileContents, 'entry', []);

		return array_filter($entries, function($entry) use ($entry_term_) {
			if (empty($entry_term_)) return true;

			$categories = ArrayHelper::getValue($entry, 'category', []);
			foreach ($categories as $category) {
				if (ArrayHelper::getValue($category, 'term') === $entry_term_ || ArrayHelper::getValue($category, '@attributes.term') === $entry_term_) {
					return true;
				}
			}
			return false;
		});
	}
}
