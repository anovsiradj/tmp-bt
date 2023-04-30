<?php

namespace Blogger\Tags;

class Section extends Tag
{
	public string $id;

	public $xmlTag = 'b:section';
	public $htmlTag = 'div';

	private array $requiredAttrs = ['id'];
	public array $sharedAttrs = ['id', 'class'];
	public array $xmlAttrs = [
		'showaddelement' => true,
	];
	public array $htmlAttrs = [];
}
