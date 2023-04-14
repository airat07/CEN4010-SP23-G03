function process_sql(b64)
{
	console.log(b64);
	var data = JSON.parse(atob(b64));
	console.log(data);

    /*
    get all image paths for display
	get tags for that image paired with image path (by array index)
	create set with all tags for listing in tag list view
    */
    var tags_set = new Set(); // non duplicated list of tags
    var images_arr = new Array(); // image urls
    var tags_arr = new Array(); // tags associated w/ ea img
    for(let i = 0; i < data.length; i++)
    {
        let curr_tags = data[i].tags.split(',');
        tags_arr.push(curr_tags);
        images_arr.push(data[i].url);   
    }
    for(let i = 0; i < tags_arr.length; i++)
    {
        for(let j = 0; j < tags_arr[i].length; j++)
        {
            tags_set.add(tags_arr[i][j]);
        }
    }

    // pass data off to thumbnail-grid
    show_thumbnails(images_arr, tags_arr);

}