$(function(){
    $('#search-box').keyup(function(event){
        // check which key was pressed
        var keyCode = event.which;
        var term = $(this).val();

        // hide all 
        $('#searchable').find().hide();
        $('#searchable').find(':Contains("' + term + '")').show();
    });
});

$.expr[':'].Contains = function(a, i, m) {
    return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
};