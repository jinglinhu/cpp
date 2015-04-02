<?php

namespace common\widgets;

use backend\assets\AppAsset;


/**
 * Class GridView
 * Theme GridView widget.
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @inheritdoc
     */
    public $tableOptions = [
        'class' => 'table table-bordered table-hover dataTable'
    ];

    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'dataTables_wrapper form-inline',
        'role' => 'grid'
    ];

    /**
     * @inheritdoc
     */
    public $layout = "{items}\n<div class='row'><div class='col-xs-6'><div class='dataTables_info'>{summary}</div></div>\n<div class='col-xs-6'><div class='dataTables_paginate paging_bootstrap'>{pager}</div></div></div>";

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        AppAsset::register($this->getView());
    }
}
