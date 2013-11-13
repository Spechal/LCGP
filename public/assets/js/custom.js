
$(document).ready(function(){
alert('running');
// Config
    var SearchBox = "#search-box";
    var SearchableElements = "#searchable blockquote";
    var SearchResultCount = "#filter-count";

    $(SearchResultCount).text($(SearchableElements).length);

// SearchBox
    $(SearchBox).keyup(function() {

        $(SearchResultCount).text("Searching ...");

        var filter = $(this).val();
        var count = 0;
        $('#searchable').unhighlight()


        $(SearchableElements).each(function() {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {

                $(this).parent().parent().animate({
                    opacity: 0
                }, 100, function() {
                    $(this).css('overflow', 'hidden').hide(100);
                });

            } else {
                $(this).parent().parent().animate({
                    opacity: 1,
                    height: '100%',
                }, 100, function() {
                    $(this).show(100);
                });
                $('#searchable').highlight(filter);
                count++;
            }
        });


        var numberItems = count;
        $(SearchResultCount).text(count);

    });
});