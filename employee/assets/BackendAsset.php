<?php

namespace employee\assets;

class BackendAsset extends \yii\web\AssetBundle
{

    public $basePath = '@webroot/backend';
    public $baseUrl = '@web/backend';
    public $css = [
        // BEGIN THEME STYLES
        'global/plugins/select2/select2.css',
        'global/plugins/select2/select2-bootstrap.css',
        'global/css/components_4.css',
        'global/css/plugins.css',
        // END THEME STYLES
        //plugins
        /*'global/plugins/bootstrap-slider/slider.css',
        'global/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css',
        'global/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'global/plugins/timepicker/bootstrap-timepicker.css',
        'global/plugins/timepicker/bootstrap-timepicker.min.css',
        'global/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
        'global/plugins/pace/pace.css',
        'global/plugins/pace/pace.min.css',*/
    ];

    public $js = [
        'global/plugins/select2/select2.min.js',
        /*'global/plugins/bootstrap-slider/bootstrap-slider.js',
        'global/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js',
        'global/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'global/plugins/timepicker/bootstrap-timepicker.js',
        'global/plugins/timepicker/bootstrap-timepicker.min.js',
        'global/plugins/input-mask/phone-codes/phone-be.json',
        'global/plugins/input-mask/phone-codes/phone-codes.json',
        'global/plugins/input-mask/jquery.inputmask.date.extensions.js',
        'global/plugins/input-mask/jquery.inputmask.extensions.js',
        'global/plugins/input-mask/jquery.inputmask.js',
        'global/plugins/input-mask/jquery.inputmask.numeric.extensions.js',
        'global/plugins/input-mask/jquery.inputmask.phone.extensions.js',
        'global/plugins/input-mask/jquery.inputmask.regex.extensions.js',
        'global/plugins/jQueryUI/jquery-ui.js',
        'global/plugins/jQueryUI/jquery-ui.min.js',
        'global/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'global/plugins/jvectormap/jquery-jvectormap-usa-en.js',
        'global/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'global/plugins/pace/pace.js',
        'global/plugins/pace/pace.min.js',*/

    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

}
