<?php

namespace Blogger\Contents;

use ErrorException;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Reader extends Component
{
    const ENTRY_TERM_SETTINGS = 'http://schemas.google.com/blogger/2008/kind#settings';
    const ENTRY_TERM_PAGE = 'http://schemas.google.com/blogger/2008/kind#page';
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

    function pages()
    {
        return $this->entries(static::ENTRY_TERM_PAGE);
    }

    /**
     * @return EntryPost[]
     */
    function posts()
    {
        return array_map(function($post) {
            return (new EntryPost(['dataEntry' => $post]));
        }, $this->entries(static::ENTRY_TERM_POST));
    }

    function settings()
    {
        return $this->entries(static::ENTRY_TERM_SETTINGS);
    }

    function setting($key)
    {
        $key = '.settings.' . $key;
        foreach ($this->settings() as $setting) {
            $id = ArrayHelper::getValue($setting, 'id', '');
            if (strpos($id, $key) !== false) {
                return $setting;
            }
        }

        return null;
    }

    /**
     * @return integer|string|null
     */
    function settingContent($key, $defaultValue = null)
    {
        $setting = $this->setting($key);
        if ($setting) return ArrayHelper::getValue($setting, 'content');

        return $defaultValue;
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
