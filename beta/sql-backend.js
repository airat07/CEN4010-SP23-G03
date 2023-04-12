function process_sql_query()
{
    $.ajax(
        {
            url: "index.php",
            type: "GET",
            dataType: "json",
            success: function(data)
            {
                console.log(data);
            }
        }
    );
}