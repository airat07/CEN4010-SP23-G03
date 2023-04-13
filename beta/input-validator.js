function validate_image_url()
{
    var image_url_input_field = $('#image-url-modal-input-field');
    //var modal_form = $('#save-new-image-modal-form');
    image_url_input_field.on('blur', function(event)
    {
        var image_url = image_url_input_field.val();

        // Send a HEAD request to the url
        $.ajax(
            {
                url: image_url,
                type: 'HEAD',
                success: function(data, textStatus, jqXHR)
                {
                    var content_type = jqXHR.getResponseHeader('Content-Type');
                    if (content_type.startsWith('image/'))
                    {
                        // valid image url
                        console.log('Valid URL');
                    }
                    else
                    {
                        console.log('Not a valid image URL!');
                        event.preventDefault();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    var content_type = jqXHR.getResponseHeader('Content-Type');
                    if (content_type.startsWith('image/'))
                    {
                        // valid image url
                        console.log('Valid image URL.');
                    }
                    else
                    {
                        console.log('Not a valid image URL!');
                        event.preventDefault();
                    }
                }
            }
        );

    });
}