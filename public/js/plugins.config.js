/**
 *@description BOOTSTRAP COLORPICKER. Input with color selection in several formats (RGB,HEX)
 *@documentation  * http://mjolnic.github.io/bootstrap-colorpicker/
 *@folder public/vendor/material/plugins/bootstrap-colorpicker
 * @param $initObject
 * selector(DOM selector): Selector to apply render plugin
 * init(json):JSON with initial configuration
 */
$.colorPicker = function ($initObject) {
    $($initObject.selector).colorpicker($initObject.init);
};


/**
 *@description JQUERY FILE PLUGIN. Render a file input with thumbnails, configure types and sizes allowed. Check the docs at:
 *@documentation https://github.com/yashiel/jquery.filer
 *@folder public/vendor/material/plugins/jQuery.filer-master
 * @param $params
 * selector(DOM selector): Set the input file selector to render
 * icon(string):Set the icon to show (fa icons)
 * buttonText(string):Set placeholder
 * filesLimit(number): Set number of files allow to charge
 * maxFileSize(number): Set a limit of file sizes in MB
 * setPreview(boolean): Set the thumbnail template instead default
 * extensions(array):Set array of extensions allowed to charge
 * showTumbs(boolean): Show or not the file thumbnail
 * @return none
 */
$.jqueryFiler = function ($params) {

    var $object = {
        limit: $params.filesLimit,
        maxSize: $params.maxFileSize,
        extensions: $params.extensions,
        changeInput: '<div class="form-group"><button type="button" id="btnAddCaracteristica" class="btn btn-default">' +
        '<i class="fa ' + $params.icon + '"></i> ' + $params.buttonText + '</button></div>',
        showThumbs: $params.showTumbs,
        theme: "dragdropbox",

        dragDrop: {
            dragEnter: null,
            dragLeave: null,
            drop: null
        },
        addMore: false,
        clipBoardPaste: true,
        captions: {
            button: "Elegir Archivo(s)",
            feedback: "Seleccionar archivo(s)",
            feedback2: "archivo(s) adjunto(s)",
            drop: "Arrastrar y soltar archivos aquí",
            removeConfirmation: "¿Remover Archivo?",
            errors: {
                filesLimit: "Sólo {{fi-limit}} archivos pueden ser adjuntados.",
                filesSize: "{{fi-name}} excede el tamaño permitido! El limite permitido es de {{fi-maxSize}} MB.",
                filesSizeAll: "Los archivos que ha elegido son demasiado grandes! El limite permitido es de {{fi-maxSize}} MB.",
                filesType: 'Solo se permiten archivos ' + $params.extensions.toString()
            }
        }
    };


    if ($params.setPreview) {
        $object["templates"] = {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
                               <div class="jFiler-item-container">\
                                   <div class="jFiler-item-inner">\
                                       <div class="jFiler-item-thumb">\
                                           <div class="jFiler-item-status"></div>\
                                           <div class="jFiler-item-info">\
                                               <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                               <span class="jFiler-item-others">{{fi-size2}}</span>\
                                           </div>\
                                           {{fi-image}}\
                                       </div>\
                                       <div class="jFiler-item-assets jFiler-row">\
                                           <ul class="list-inline pull-left">\
                                               <li>{{fi-progressBar}}</li>\
                                           </ul>\
                                           <ul class="list-inline pull-right">\
                                               <li><a class="btn btn-xs btn-danger-store jFiler-item-trash-action"><i class="glyphicon glyphicon-trash"></i></a><!--<a class="icon-jfi-trash jFiler-item-trash-action"></a>--></li>\
                                           </ul>\
                                       </div>\
                                   </div>\
                               </div>\
                           </li>',
            itemAppend: '<li class="jFiler-item">\
                                   <div class="jFiler-item-container">\
                                       <div class="jFiler-item-inner">\
                                           <div class="jFiler-item-thumb">\
                                               <div class="jFiler-item-status"></div>\
                                               <div class="jFiler-item-info">\
                                                   <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                                   <span class="jFiler-item-others">{{fi-size2}}</span>\
                                               </div>\
                                               {{fi-image}}\
                                           </div>\
                                           <div class="jFiler-item-assets jFiler-row">\
                                               <ul class="list-inline pull-left">\
                                                   <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                               </ul>\
                                               <ul class="list-inline pull-right">\
                                                   <li><a class="btn btn-xs btn-danger-store jFiler-item-trash-action"><i class="glyphicon glyphicon-trash"></i></a><!--<a class="icon-jfi-trash jFiler-item-trash-action"></a>--></li>\
                                               </ul>\
                                           </div>\
                                       </div>\
                                   </div>\
                               </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        };
    }
    $($params.selector).filer($object);

};