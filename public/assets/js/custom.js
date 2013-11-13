jQuery.extend({highlight:function(a,b,c,d){if(a.nodeType===3){var e=a.data.match(b);if(e){var f=document.createElement(c||"span");f.className=d||"highlight";var g=a.splitText(e.index);g.splitText(e[0].length);var h=g.cloneNode(true);f.appendChild(h);g.parentNode.replaceChild(f,g);return 1}}else if(a.nodeType===1&&a.childNodes&&!/(script|style)/i.test(a.tagName)&&!(a.tagName===c.toUpperCase()&&a.className===d)){for(var i=0;i<a.childNodes.length;i++){i+=jQuery.highlight(a.childNodes[i],b,c,d)}}return 0}});jQuery.fn.unhighlight=function(a){var b={className:"highlight",element:"span"};jQuery.extend(b,a);return this.find(b.element+"."+b.className).each(function(){var a=this.parentNode;a.replaceChild(this.firstChild,this);a.normalize()}).end()};jQuery.fn.highlight=function(a,b){var c={className:"highlight",element:"span",caseSensitive:false,wordsOnly:false};jQuery.extend(c,b);if(a.constructor===String){a=[a]}a=jQuery.grep(a,function(a,b){return a!=""});a=jQuery.map(a,function(a,b){return a.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&")});if(a.length==0){return this}var d=c.caseSensitive?"":"i";var e="("+a.join("|")+")";if(c.wordsOnly){e="\\b"+e+"\\b"}var f=new RegExp(e,d);return this.each(function(){jQuery.highlight(this,f,c.element,c.className)})}

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