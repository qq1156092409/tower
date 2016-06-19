/**
 * @required SimditorAsset
 */
yii.simditor=(function($){
    var editor;
    /**
     * 0:小 1:doc
     */
    var toolbars=[
        [
            'emoji', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', '|',
            'ol', 'ul', 'blockquote', 'code', 'indent', 'outdent', '|',
            'link', 'image'//todo attachment
        ],
        [
            'title','bold', 'italic', 'underline', 'strikethrough', 'fontScale', '|',
            'ol', 'ul', 'blockquote', 'code', 'indent', 'outdent', '|',
            'link', 'image','hr','table'
        ]
    ];
    function init(){
        run();
    }
    function run(){
        var $textarea=$('#editor');
        var params={};
        params[yii.getCsrfParam()]=yii.getCsrfToken();
        editor=new Simditor({
            textarea: $textarea,
            toolbar: toolbars[$textarea.data("toolbar")?$textarea.data("toolbar"):0],
            upload:{
                url:"index.php?r=attachment/simditor",
                params: params,
                fileKey: 'file',
                connectionCount: 3,
                leaveConfirm: '文件正在上传，确定要离开吗？'
            },
            emoji: {
                imagePath: 'plugins/simditor/images/emoji/'
            }
        });
    }
    function getEditor(){
        return editor;
    }
    return {
        init:init,
        getEditor:getEditor
    };
})(jQuery);