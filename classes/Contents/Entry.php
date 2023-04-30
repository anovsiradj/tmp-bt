<?php

namespace Blogger\Contents;

use DateTime;
use yii\base\Model;
use yii\helpers\Inflector;

/**
 * @property DateTime $published
 * @property DateTime $updated
 * @property DateTime $created
 */
class Entry extends Model
{
	public array $dataEntry = [];

	public $title;
	public $content;

	public function init()
	{
		parent::init();
		$this->loadEntry();
	}

	function scenarios()
	{
		return [static::SCENARIO_DEFAULT => array_keys($this->modelEntry(true))];
	}

	protected function modelEntry($hasPropertyOnly)
	{
		$post = [];
		foreach ($this->dataEntry as $k => $v) {
			$k = Inflector::variablize($k);
			if ($hasPropertyOnly && !$this->hasProperty($k)) continue;
			$post[$k] = $v;
		}
		return $post;
	}

	function loadEntry(array $dataEntry = [])
	{
		$this->dataEntry = array_merge($this->dataEntry, $dataEntry);
		$this->load([$this->formName() => $this->modelEntry(true)]);
	}

	function setPublished($v)
	{
		$this->published = $this->created = ($v instanceof DateTime) ? $v : new DateTime($v);
	}
	function getPublished($format = DateTime::ISO8601)
	{
		return $this->published->format($format);
	}

	function setCreated($v)
	{
		$this->setPublished($v);
	}
	function getCreated($format = DateTime::ISO8601)
	{
		return $this->getPublished($format);
	}

	function setUpdated($v)
	{
		$this->updated = ($v instanceof DateTime) ? $v : new DateTime($v);
	}
	function getUpdated($format = DateTime::ISO8601)
	{
		return $this->updated->format($format);
	}
}
