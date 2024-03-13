//jquery search functionality without php

$(document).ready(function(){
    $("#search").keyup(function(){
        var search = $(this).val();
        $.ajax({
            url: 'search.php',
            type: 'post',
            data: {query:search},
            success: function(response){
                $("#show-list").html(response);
            }
        });
    });
    $(document).on('click', 'a', function(){
        $("#search").val($(this).text());
        $("#show-list").html("");
    });
});