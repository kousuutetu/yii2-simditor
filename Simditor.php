<?php

namespace Jeff\simditor;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

class Simditor extends \yii\widgets\InputWidget
{
    public $editorOptions = [];

    public function run()
    {
        SimditorAsset::register($this->getView());
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $javascript = implode($this->processOptions(), ',');
        $this->getView()->registerJs('var editor = new Simditor({'.$javascript.'});', View::POS_END);
    }

    public function processOptions()
    {
        $options = [];

        if (isset($this->editorOptions['textarea'])) {
            $options['textarea'] = 'textarea: $("'.$this->editorOptions['textarea'].'")';
        } else {
            $options['textarea'] = 'textarea: $("#'.$this->options['id'].'")';
        }
        if (isset($this->editorOptions['placeholder'])) {
            $options['placeholder'] = 'placeholder: "'.$this->editorOptions['placeholder'].'"';
        }
        if (isset($this->editorOptions['toolbar'])) {
            $options['toolbar'] = 'toolbar: ["'.implode($this->editorOptions['toolbar'], '","').'"]';
        }
        if (isset($this->editorOptions['toolbarFloat'])) {
            $options['toolbarFloat'] = 'toolbarFloat: '.($this->editorOptions['toolbarFloat'] ? 'true' : 'false');
        }
        if (isset($this->editorOptions['toolbarFloatOffset'])) {
            $options['toolbarFloatOffset'] = 'toolbarFloatOffset: '.$this->editorOptions['toolbarFloatOffset'];
        }
        if (isset($this->editorOptions['toolbarHidden'])) {
            $options['toolbarHidden'] = 'toolbarHidden: '.($this->editorOptions['toolbarHidden'] ? 'true' : 'false');
        }
        if (isset($this->editorOptions['defaultImage'])) {
            $options['defaultImage'] = 'defaultImage: "'.$this->editorOptions['defaultImage'].'"';
        } else {
            $options['defaultImage'] = 'defaultImage: ""';
        }
        if (isset($this->editorOptions['tabIndent'])) {
            $options['tabIndent'] = 'tabIndent: '.($this->editorOptions['tabIndent'] ? 'true' : 'false');
        }
        if (isset($this->editorOptions['params'])) {
            $options['params'] = 'params: "'.$this->editorOptions['params'].'"';
        }
        if (isset($this->editorOptions['upload'])) {
            $uploadOptions = [];
            if (!isset($this->editorOptions['upload']['url'])) {
                $uploadOptions['url'] = 'url: ""';
            } else {
                $uploadOptions['url'] = 'url: "'.Url::to($this->editorOptions['upload']['url']).'"';
            }
            if (isset($this->editorOptions['upload']['params'])) {
                $uploadOptions['params'] = 'params: "'.$this->editorOptions['upload']['params'].'"';
            }
            if (isset($this->editorOptions['upload']['fileKey'])) {
                $uploadOptions['fileKey'] = 'fileKey: "'.$this->editorOptions['upload']['fileKey'].'"';
            }
            if (isset($this->editorOptions['upload']['connectionCount'])) {
                $uploadOptions['connectionCount'] = 'connectionCount: '.intval($this->editorOptions['upload']['connectionCount']);
            }
            if (isset($this->editorOptions['upload']['leaveConfirm'])) {
                $uploadOptions['leaveConfirm'] = 'leaveConfirm: "'.$this->editorOptions['upload']['leaveConfirm'].'"';
            }
            $options['upload'] = 'upload: {'.implode($uploadOptions, ',').'}';

            if (isset($this->editorOptions['pasteImage'])) {
                $options['pasteImage'] = 'pasteImage: '.($this->editorOptions['pasteImage'] ? 'true' : 'false');
            }
        }
        if (isset($this->editorOptions['imageButton'])) {
            $imageButtonRange = ['upload', 'external'];
            if (is_string($this->editorOptions['imageButton']) && in_array($this->editorOptions['imageButton'], $imageButtonRange)) {
                $options['imageButton'] = 'imageButton: '.$this->editorOptions['imageButton'];
            }
            if (is_array($this->editorOptions['imageButton'])) {
                $imageButtons = array_diff($imageButtonRange, $this->editorOptions['imageButton']);
                $options['imageButton'] = 'imageButton: ["'.implode($imageButtons, '","').'"]';
            }
        }
        if (isset($this->editorOptions['allowedTags']) && is_array($this->editorOptions['allowedTags'])) {
            $options['allowedTags'] = 'allowedTags: ["'.implode($this->editorOptions['allowedTags'], '","').'"]';
        }
        if (isset($this->editorOptions['allowedAttributes']) && is_array($this->editorOptions['allowedAttributes'])) {
            $options['allowedTags'] = 'allowedTags: ["'.implode($this->editorOptions['allowedTags'], '","').'"]';
        }

        return $options;
    }
}
