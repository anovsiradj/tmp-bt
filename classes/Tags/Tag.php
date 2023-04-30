<?php

namespace Blogger\Tags;

use yii\base\Component;
use yii\base\ErrorException;
use Yiisoft\Html\Html;

class Tag extends Component
{
	protected string $tag;
	public $xmlTag;
	public $htmlTag;

	protected array $attrs = [];
	public array $xmlAttrs = [];
	public array $htmlAttrs = [];

	protected array $sharedAttrs = [];

	public function init()
	{
		parent::init();

		if (!defined('BTEMPLATES_MODE')) throw new ErrorException('Undefined "BTEMPLATES_MODE"');

		switch (BTEMPLATES_MODE) {
			case 'xml':
				$this->tag = $this->xmlTag;
			break;
			case 'html':
				$this->tag = $this->htmlTag;
			break;
			default:
				throw new ErrorException(printf('Unknown "%s" BTEMPLATES_MODE', BTEMPLATES_MODE));
			break;
		}
	}

	public function open()
	{
		echo Html::openTag($this->tag, $this->attrs);
	}

	public function close()
	{
		echo Html::closeTag($this->tag);
	}

	function content(callable $callback)
	{
		$this->open();
		echo $callback();
		$this->close();
	}
}
