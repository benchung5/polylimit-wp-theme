jQuery(document).ready( function($) {
    function media_upload(button_class) {
        var _custom_media = true;
        _orig_send_attachment = wp.media.editor.send.attachment;

        $('body').on('click', button_class, function(e) {
            
            //get the idea of the associated input from the data attribute in the button
            var id = $(this).data('input-id');
//            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(id);
//            var id = button.attr('id').replace('_button', '');
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _custom_media  ) {
                    $('#' + id + '.custom_media_id').val(attachment.id);
                    $('#' + id + '.custom_media_url').val(attachment.url);
                    $('#' + id + '.custom_media_image').attr('src',attachment.url).css('display','block');
                } else {
                    return _orig_send_attachment.apply( id, [props, attachment] );
                }
            }
            wp.media.editor.open(button);
                return false;
        });
    }
    media_upload('.upload-media-btn');
});