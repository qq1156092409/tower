/**
 * Yii GridView widget.
 *
 * This is the JavaScript widget used by the yii\grid\GridView widget.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
(function ($) {
    /**
     * 入口
     * @param method object|string
     * @returns {*}
     */
    $.fn.yiiGridView = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiGridView');
            return false;
        }
    };
    /**
     * 默认配置
     * @type {{filterUrl: undefined, filterSelector: undefined}}
     */
    var defaults = {
        filterUrl: undefined,//筛选路径
        filterSelector: undefined//筛选选择器
    };
    /**
     * 缓存表格数据
     * @type {{}}
     */
    var gridData = {};

    var methods = {
        /**
         * 初始化
         * 主要与过滤相关
         * @this jQuery $elements
         * @param options
         * @returns {*}
         */
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                gridData[$e.prop('id')] = {settings: settings};

                var enterPressed = false;
                $(document).off('change.yiiGridView keydown.yiiGridView', settings.filterSelector)
                    .on('change.yiiGridView keydown.yiiGridView', settings.filterSelector, function (event) {
                        if (event.type === 'keydown') {
                            if (event.keyCode !== 13) {
                                return; // only react to enter key
                            } else {
                                enterPressed = true;
                            }
                        } else {
                            // prevent processing for both keydown and change events
                            if (enterPressed) {
                                enterPressed = false;
                                return;
                            }
                        }

                        methods.applyFilter.apply($e);

                        return false;
                    });
            });
        },
        /**
         * 过滤
         */
        applyFilter: function () {
            var $grid = $(this);
            var settings = gridData[$grid.prop('id')].settings;
            var data = {};
            $.each($(settings.filterSelector).serializeArray(), function () {
                data[this.name] = this.value;
            });

            $.each(yii.getQueryParams(settings.filterUrl), function (name, value) {
                if (data[name] === undefined) {
                    data[name] = value;
                }
            });

            var pos = settings.filterUrl.indexOf('?');
            var url = pos < 0 ? settings.filterUrl : settings.filterUrl.substring(0, pos);

            $grid.find('form.gridview-filter-form').remove();
            var $form = $('<form action="' + url + '" method="get" class="gridview-filter-form" style="display:none" data-pjax></form>').appendTo($grid);
            $.each(data, function (name, value) {
                $form.append($('<input type="hidden" name="t" value="" />').attr('name', name).val(value));
            });
            $form.submit();
        },
        /**
         * CheckboxColumn：注册选中列事件
         * @param options object {multiple,checkAll,name}
         */
        setSelectionColumn: function (options) {
            var $grid = $(this);
            var id = $(this).prop('id');
            gridData[id].selectionColumn = options.name;
            if (!options.multiple) {
                return;
            }
            var inputs = "#" + id + " input[name='" + options.checkAll + "']";
            $(document).off('click.yiiGridView', inputs).on('click.yiiGridView', inputs, function () {
                $grid.find("input[name='" + options.name + "']:enabled").prop('checked', this.checked);
            });
            $(document).off('click.yiiGridView', inputs + ":enabled").on('click.yiiGridView', inputs + ":enabled", function () {
                var all = $grid.find("input[name='" + options.name + "']").length == $grid.find("input[name='" + options.name + "']:checked").length;
                $grid.find("input[name='" + options.checkAll + "']").prop('checked', all);
            });
        },
        /**
         * 获取选中的行
         * @returns {Array}
         */
        getSelectedRows: function () {
            var $grid = $(this);
            var data = gridData[$grid.prop('id')];
            var keys = [];
            if (data.selectionColumn) {
                $grid.find("input[name='" + data.selectionColumn + "']:checked").each(function () {
                    keys.push($(this).parent().closest('tr').data('key'));
                });
            }
            return keys;
        },

        destroy: function () {
            return this.each(function () {
                $(window).unbind('.yiiGridView');
                $(this).removeData('yiiGridView');
            });
        },

        data: function () {
            var id = $(this).prop('id');
            return gridData[id];
        }
    };
})(window.jQuery);

