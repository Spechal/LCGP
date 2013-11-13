jQuery.fn.highlight = function(pat) {
    function innerHighlight(node, pat) {
        var skip = 0;
        if (node.nodeType == 3) {
            var pos = node.data.toUpperCase().indexOf(pat);
            if (pos >= 0) {
                var spannode = document.createElement('span');
                spannode.className = 'highlight';
                var middlebit = node.splitText(pos);
                var endbit = middlebit.splitText(pat.length);
                var middleclone = middlebit.cloneNode(true);
                spannode.appendChild(middleclone);
                middlebit.parentNode.replaceChild(spannode, middlebit);
                skip = 1;
            }
        }
        else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
            for (var i = 0; i < node.childNodes.length; ++i) {
                i += innerHighlight(node.childNodes[i], pat);
            }
        }
        return skip;
    }
    return this.length && pat && pat.length ? this.each(function() {
        innerHighlight(this, pat.toUpperCase());
    }) : this;
};

jQuery.fn.removeHighlight = function() {
    return this.find("span.highlight").each(function() {
        this.parentNode.firstChild.nodeName;
        with (this.parentNode) {
            replaceChild(this.firstChild, this);
            normalize();
        }
    }).end();
};

$(document).ready(function(){

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
        $('#searchable').removeHighlight()


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
                    height: '100%'
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