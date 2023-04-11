console.log("test from thumbnail-grid.js");



// Array of image URLs
var images = [
    "images/photo1.jpg",
    "images/photo2.jpg",
    "images/photo3.jpg",
    "images/photo4.jpg",
    "images/photo5.jpg",
    "images/photo6.jpg"
];

// Add images to grid
var grid = $("#thumbnail-grid");
function show_thumbnails()
{
    grid.html("");
    for (var i = 0; i < images.length; i++)
    {
        var id = i.toString();
        grid.append(`
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="${images[i]}" class="card-img-top" id="${id}" alt="...">
                    <div class="card-body">
                        <p class="card-text">Thumbnail description goes here</p>
                        
    
                    </div>
                </div>
    
            </div>`);
    }
}
// display tag list when thumbnail is clicked
const map1 = new Map();
map1.set(0, ['tag1', 'tag2', 'tag3', 'tag']);
map1.set(1, ['space', 'another tag', 'unique tag', 'tag with an ! mark']);
map1.set(2, ['cool', 'nature']);
map1.set(3, ['tagged!!!!', 'yet another cool tag', 'tag']);
map1.set(4, ['nice tag', 'tag18', 'tag27']);
map1.set(5, ['image with nothing interesting', 'cool', 'rare', 'mysterious', 'nature', 'space']);

// get tags for this image.
// this code is purely to help demonstrate the intended functionality of the app
// and will eventually be replaced.
// proper backend implementation will reflect the behavior we currently have here

function set_thumbnail_callbacks()
{
    var thumbnails = $(".card-img-top");
    thumbnails.each(function(index)
    {
        //console.log(index + ": " + $(this).attr("id"));
        thumbnails.off().on("click", function(event)
        {
            //console.log("this thumbnail id is: " + $(this).attr("id"));
            event.stopPropagation();
            console.log(parseInt($(this).attr("id")));
            thumbnail_id = parseInt($(this).attr("id")); // id attribute is set when thumbnails are populated into grid

            var taglist = $("#the-tag-list");
            taglist.html("");
            for(var i = 0; i < map1.get(thumbnail_id).length; i++)
            {
                taglist.append(
                    `
                        <li class="list-group-item">${map1.get(thumbnail_id)[i]}</li>
                    `
                );
            }

        });
        
    
    });
}
set_thumbnail_callbacks();



// search box functionality
// todo: move this code out of this file (maybe)

function tag_search()
{
    console.log("submit button pressed!");
    var search_box = $("#search-box");
    var search_query = search_box.val();

    // for now, we only support search by a single tag
    // the plan obviously is to support multiple tags in a search query
    // as well as search by md5 or sha256 hash and/or filename

    // the plan here is to query SQL on the server, get the value back here in JavaScript land
    // and operate on the return values here

    // for now we do: if a tag being searched for exists in any of the arrays in map1, we display
    // its thumbnail in the thumbnail-grid
    var thumbnails_to_show = []; // array of thumbnail ids (assigned in thumbnail-grid code...)
    for(const [key, value] of map1.entries())
    {
        if (value.includes(search_query))
        {
            thumbnails_to_show.push(key);
        }
    }

    console.log(thumbnails_to_show);
    grid.html("");
    thumbnails_to_show.forEach(function(value)
    {
        console.log("showing thumbnails...");
        console.log(value);
        
        // this part is somewhat duplicated and needs to be moved to a function but
        // it's not really important because this whole backend will be changed when proper SQL support is put in place
        var id = value.toString();
        grid.append(`
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card">
                <img src="${images[value]}" class="card-img-top" id="${id}" alt="...">
                <div class="card-body">
                    <p class="card-text">Thumbnail description goes here</p>
                    

                </div>
            </div>

        </div>`);

        // callbacks for thumbnail clicks need to be reset now...
        
    });

    set_thumbnail_callbacks();

}

var form = $("#search-form");
form.on("submit", false);

var search_button = $("#search-button");
search_button.off().on("click", function(event)
{
    event.stopPropagation();
    tag_search();
    
});

var everything_button = $("#everything-button");
everything_button.off().on("click", function(event)
{
    event.stopPropagation();
    show_thumbnails();
    set_thumbnail_callbacks();
})




//thumbnails.forEach(thumbnail => 
//    {
//        thumbnail.addEventListener('click', () => 
//        {
//            // get tags for this image.
//            // this code is purely to help demonstrate the intended functionality of the app
//            // and will eventually be replaced.
//            // proper backend implementation will reflect the behavior we currently have here
//
//            //const tags = ['tag1', 'tag2', 'tag3'];
//            //const tags2 = ['another tag', 'unique tag', 'tag with an ! mark'];
//            //console.log(tags);
//
//            // bunch of hardcoded tags
//            // eventually, we will use SQL to retrieve a list of tags given an image sha256 hash
//            const map1 = new Map();
//            map1.set(1, ['tag1', 'tag2', 'tag3']);
//            map1.set(2, ['another tag', 'unique tag', 'tag with an ! mark']);
//            map1.set(3, ['cool tag']);
//            map1.set(4, ['tagged!!!!', 'yet another cool tag']);
//            map1.set(5, ['nice tag', 'tag18', 'tag27']);
//            map1.set(6, ['image with nothing interesting', 'cool', 'rare', 'mysterious', 'nature', 'space']);
//
//
//
//            // clear tag list and add the acquired tags for this image
//            var taglist = $("#the-tag-list");
//            taglist.innerHTML = '';
//            for(var i = 0; i < map1.get(parseInt(thumbnails.attr("id"))).length; i++)
//            {
//                taglist.append(
//                    `
//                        <li class="list-group-item">${map1.get(parseInt(thumbnails.attr("id")))[i]}</li>
//                    `
//                );
//            }
//        });
//
//    });
