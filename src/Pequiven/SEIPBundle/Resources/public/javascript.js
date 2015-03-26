$(function() {
        $('a.showPopup').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var horizontalPadding = 10;
            var verticalPadding = 10;
            var width = 1200;
            var heigth = 600;
            $('<iframe id="site" src="' + this.href + '" style="padding:0"/>').dialog({
                title: ($this.attr('title')) ? $this.attr('title') : 'Site',
                autoOpen: true,
                width: width,
                height: heigth,
                modal: true,
                resizable: true,
                autoResize: true,
                overlay: {
                    opacity: 0.5,
                    background: "black"
                }
            }).width(width - horizontalPadding).height(heigth - verticalPadding);
        });
});