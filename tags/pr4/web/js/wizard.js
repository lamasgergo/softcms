(function() {
    jQuery.fn.wizard = function(options) {
        var defaults = {
            containerClassName: 'wizard',
            pageSelector : '.page',
            drawerSelector: '#drawer',
            stepsSelector: '.steps',
            nextButtonSelector: 'button.next',
            prevButtonSelector: 'button.next'
        };

        return this.each(function() {
            var self = $(this);
            var opts = $.extend(true, {}, defaults, options);

            $(this).addClass(opts.containerClassName);

            var root = $(this).scrollable();

            // some variables that we need
            var api = root.scrollable(), drawer = self.find(opts.drawerSelector);

            // validation logic is done inside the onBeforeSeek callback
            api.onBeforeSeek(function(event, i) {

                // we are going 1 step backwards so no need for validation
                if (api.getIndex() < i) {

                    // 1. get current page
                    var page = root.find(opts.pageSelector).eq(api.getIndex()),

                        // 2. .. and all required fields inside the page
                            inputs = page.find(".required :input").removeClass("error"),

                        // 3. .. which are empty
                            empty = inputs.filter(function() {
                                return $(this).val().replace(/\s*/g, '') == '';
                            });

                    // if there are empty fields, then
                    if (empty.length) {

                        // slide down the drawer
                        drawer.slideDown(function()  {

                            // colored flash effect
                            drawer.css("backgroundColor", "#229");
                            setTimeout(function() { drawer.css("backgroundColor", "#fff"); }, 1000);
                        });

                        // add a CSS class name "error" for empty & required fields
                        empty.addClass("error");

                        // cancel seeking of the scrollable by returning false
                        return false;

                        // everything is good
                    } else {

                        // hide the drawer
                        drawer.slideUp();
                    }

                }
                
                // update status bar
                self.find(opts.stepsSelector +' > li').removeClass("active").eq(i).addClass("active");

            });

            if (!self.find(opts.stepsSelector +'> li').hasClass("active")){
                self.find(opts.stepsSelector +'> li').removeClass("active").eq(0).addClass("active");
            }

            // if tab is pressed on the next button seek to next page
            root.find(opts.nextButtonSelector).keydown(function(e) {
                if (e.keyCode == 9) {

                    // seeks to next tab by executing our validation routine
                    api.next();
                    e.preventDefault();
                }
            });

        });
    }
})();