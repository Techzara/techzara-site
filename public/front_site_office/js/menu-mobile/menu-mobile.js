jQuery(document).ready(function ($) {

        (function slideMenu() {

            var trigger = '.trigger'; // the triger class
            var showslide = 'menu-active'; // the active class that is added to the body
            var body = 'body'; //body of element
            var close = '.slide-close'; // the class that closes the slide
            var slideout = 'slideout'; // the class to show the slide
            var mainId = '#slide-menu' //main wrapper ID

            //open the slide and add class to body to use with css
            jQuery(trigger).click(function () {

                jQuery(body).toggleClass(showslide);
                jQuery(mainId).toggleClass(slideout);

            });

            //close the slide
            jQuery(close).click(function () {

                jQuery(body).removeClass(showslide);
                jQuery(mainId).removeClass(slideout);
            });

        }).call(this);

    }());