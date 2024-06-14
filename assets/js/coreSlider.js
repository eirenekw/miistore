/*
 * CoreSlider v1.0.0
 * Copyright 2016 Pavel Davydov
 *
 * Licensed under MIT (http://opensource.org/licenses/MIT)
 */

(function($) {

  'use strict';

  $.coreSlider = function(container, options) {

    this.defaults = {
      interval: 5000,                                         // Interval of time between slide changes
      loop: true,                                             // When slider finish, should it loop again from first slide?
      slideshow: true,                                        // Enable/Disable automatic slideshow
      resize: true,                                           // Should be slider responsive on screen resize
      pauseOnHover: true,                                     // Pause the slideshow when hovering over slider
      startOnHover: false,                                    // Start the slideshow when hovering over slider
      sliderSelector: '.core-slider_list',                    // List selector (all items are inside this container)
      viewportSelector: '.core-slider_viewport',              // Viewport selector
      itemSelector: '.core-slider_item',                      // Slider items selector
      navEnabled: true,                                       // Enable/Disable navigation arrows
      navSelector: '.core-slider_nav',                        // Selector for navigation arrows container
      navItemNextSelector: '.core-slider_arrow__right',       // 'Next' arrow selector
      navItemPrevSelector: '.core-slider_arrow__left',        // 'Prev' arrow selector
      controlNavEnabled: false,                               // Enable/Disable control navigation (dots)
      controlNavSelector: '.core-slider_control-nav',         // Control navigation container selector (inside will be created dots items)
      controlNavItemSelector: 'core-slider_control-nav-item', // Single control nav dot (created dynamically. Write without dot. If you need more that one class - add them with space separator)
      loadedClass: 'is-loaded',                               // Classname, that will be added when slider is fully loaded
      clonedClass: 'is-cloned',                               // Classname, that will be added to cloned slides (see option 'clone')
      disabledClass: 'is-disabled',                           // Classname, that will be added it item is disabled (in most of cases - item will be display: noned)
      activeClass: 'is-active',                               // Classname, that will be added to active items (for example control navs, etc.)
      reloadGif: false,                                       // Reload gif's on slide change for replaying cycled animation inside current slide
      clone: false,                                           // Indicates, that at begin and at end of slider carousel items will be cloned to create 'infitite' carousel illusion
      items: 1,                                               // How mutch items will be placed inside viewport. Leave 1 if this is slider, 2 ot more - it will look like a carousel
      itemsPerSlide: 1,                                       // How many items must be slided by one action (NOTE: Must be less than 'items' option)
      cloneItems: 0                                           // How mutch items will be cloned at begin and at end of slider
    };

    // Extend defaults with settings passed on init
    this.settings = $.extend({}, this.defaults, options);

    var self = this,
        animateInterval,
        $sliderContainer = $(container),
        $sliderViewport = $sliderContainer.find(self.settings.viewportSelector),
        $slider = $sliderContainer.find(self.settings.sliderSelector),
        $sliderItems = $sliderContainer.find(self.settings.itemSelector),
        $clonedSliderItems = null,
        $sliderNav = $sliderContainer.find(self.settings.navSelector),
        $sliderPrevBtn = $sliderContainer.find(self.settings.navItemPrevSelector),
        $sliderNextBtn = $sliderContainer.find(self.settings.navItemNextSelector),
        $sliderControlNav = $sliderContainer.find(self.settings.controlNavSelector),
        $sliderControlNavItems,
        slideCount = $sliderItems.length - 1, // Count, with counter, starting from zero
        slideCountTotal = $sliderItems.length,
        slideWidth, // Single slide width
        currentSlide = 0,
        transformPrefix = getVendorPrefixes(["transform", "msTransform", "MozTransform", "WebkitTransform"]),
        resizeTimeout,
        currentUrl = null,
        currentTags = null,
        remainingItems = {
          left: 0,
          right: 0
        }, // Number of items remaining on left and on right around visible part
        isFirstLoad = true; // Indicates, that slider was first loaded

    // Getter for vendor prefixes
    function getVendorPrefixes(prefixes) {
      var tmp = document.createElement("div"),
          result = ""; // Store results here
      for (var i = 0; i < prefixes.length; i++) {
        if (typeof tmp.style[prefixes[i]] != 'undefined') {
          result = prefixes[i];
          break;
        } else {
          result = null;
        }
      }
      return result;
    }

    function getTranslateX(offset) {
      return 'translateX(' + offset + 'px)';
    }

    // Initialization of slider
    this.init = function() {
      // Set inner container sizes
      $sliderContainer.addClass(self.settings.loadedClass);
      if (self.settings.clone) {
        // If clone is enabled - clone slides on end and on begin of slider
        self.cloneSlides();
      }
      self.setSizes();
      self.setSlide(currentSlide, false);
      if (self.settings.slideshow) {
        self.play();
      }
      if (self.settings.resize) {
        self.resize();
      }
      // Pause on hover events
      if (self.settings.pauseOnHover && self.settings.slideshow) {
        $sliderContainer.mouseenter(function() {
          self.stop();
        });
        $sliderContainer.mouseleave(function() {
          self.play();
        });
      }
      // Start on hover events
      if (self.settings.startOnHover && self.settings.slideshow) {
        $sliderContainer.mouseenter(function() {
          self.play();
        });
        $sliderContainer.mouseleave(function() {
          self.stop();
        });
      }

      // Add handlers for slider navs (prev/next)
      if (self.settings.navEnabled) {
        $sliderPrevBtn.on('click', function() {
          if(!$(this).hasClass(self.settings.disabledClass)) {
            self.setSlide(currentSlide - self.settings.itemsPerSlide, true);
          }
        });
        $sliderNextBtn.on('click', function() {
          if(!$(this).hasClass(self.settings.disabledClass)) {
            self.setSlide(currentSlide + self.settings.itemsPerSlide, true);
          }
        });
      } else {
        // Add disabled class for navigration arrows
        $sliderNav.addClass(self.settings.disabledClass);
      }

      // Add handlers and init slider control navs
      if (self.settings.controlNavEnabled) {
        // Create dynamically dot items and append them to container
        var buffer = []; // Container of all dot items that will be created later
        for (var i = 0; i < slideCount + 1; i++) {
          if (i == currentSlide) {
            // Make current item active from begin
            buffer.push('<div class="' + self.settings.controlNavItemSelector + ' ' + self.settings.activeClass + '"></div>');
          } else {
            buffer.push('<div class="' + self.settings.controlNavItemSelector + '"></div>');
          }
        }
        $sliderControlNav.append(buffer.join(''));
        // Cache all items in variable
        $sliderControlNavItems = $sliderControlNav.children();
        // Add event handlers to container
        $sliderControlNav.on('click', $sliderControlNavItems, function(e) {
          self.setSlide($(e.target).index(), false);
        });
        // If items are less then viewport - add disabled classes
        if (slideCountTotal <= self.settings.items) {
          $sliderNextBtn.addClass(self.settings.disabledClass);
          $sliderPrevBtn.addClass(self.settings.disabledClass);
        }
      } else {
        // Add disabled class for navigration dots
        $sliderControlNav.addClass(self.settings.disabledClass);
      }
    };

    this.cloneSlides = function() {
      // Prepend first last items at begin of slider and first elements on end of slider
      $slider.append($sliderItems.slice(0, self.settings.cloneItems).clone().addClass(self.settings.clonedClass));
      $slider.prepend($sliderItems.slice(slideCount - self.settings.cloneItems + 1, slideCount + 1).clone().addClass(self.settings.clonedClass));
      // Cache cloned items in variable
      $clonedSliderItems = $sliderContainer.find(self.settings.itemSelector).filter('.' + self.settings.clonedClass);
    };

    // Function for setting sizes for each item in slider
    this.setSizes = function() {
      slideWidth = $sliderViewport.width() / self.settings.items;
      $sliderItems.add($clonedSliderItems).css('width', slideWidth);
      $slider.css('width', slideWidth * (slideCount + self.settings.cloneItems*2 +  1));
      // $slider.css('width', slideWidth * (slideCount + self.settings.items * 2 + 1) * 1.3);
    };

    // Main function that moves slides. Set slide by passed index as parameter
    this.setSlide = function(index, isDirectionNav) {
      var isDirectionNavClick = isDirectionNav; // Indicates that click was from arrow navigation

      self.stop();

      if(remainingItems.left === 0 && !self.settings.loop) {
        $sliderPrevBtn.addClass(self.settings.disabledClass);
      }

      // Play animation only if total number of items is less than number visible in viewport
      if (slideCountTotal > self.settings.items && isDirectionNavClick) {
        // Get number of remaining on right items
        remainingItems.right = (slideCount + 1) - currentSlide - self.settings.items;
        remainingItems.left = currentSlide;

        $sliderNextBtn.removeClass(self.settings.disabledClass);
        $sliderPrevBtn.removeClass(self.settings.disabledClass);

        // Get direction
        if (currentSlide - index < 0) {
          // Right direction
          if (remainingItems.right <= self.settings.itemsPerSlide) {
            index = slideCount - self.settings.items + 1;
            // Set disabled class for nav
            if (!self.settings.loop) {
              $sliderNextBtn.addClass(self.settings.disabledClass);
            }
          }
          if (remainingItems.right == 0) {
            index = 0; // If loop enavled - rollup to first slide
          }
        } else {
          // Left direction
          if (remainingItems.left <= self.settings.itemsPerSlide) {
            index = 0;
            if (!self.settings.loop) {
              $sliderPrevBtn.addClass(self.settings.disabledClass);
            }
          }
          if (remainingItems.left == 0 && !isFirstLoad) {
            index = slideCount - self.settings.items + 1;
          }
        }

        // Replay possible animations in gif's
        if (self.settings.reloadGif) {
          currentTags = $sliderItems.eq(index).find('img');
          currentTags.each(function() {
            var $this = $(this);
            currentUrl = $this.attr('src');
            $this.attr('src', '');
            $this.attr('src', currentUrl);
          });
        }
      }

      if(!isDirectionNavClick && self.settings.controlNavEnabled) {
        // Set slide directly (for example from dots or from extenal API), including items cloning
        index = (index > slideCount - self.settings.items + self.settings.cloneItems + 1) ? slideCount - self.settings.items + self.settings.cloneItems + 1 : index;
      }

      // Set active new control nav item
      if (self.settings.controlNavEnabled && typeof $sliderControlNavItems !== 'undefined') {
        $sliderControlNavItems.removeClass(self.settings.activeClass);
        $sliderControlNavItems.eq(index).addClass(self.settings.activeClass);
      }

      // Apply CSS transition to block
      $slider.css(transformPrefix, getTranslateX(-(index + self.settings.cloneItems) * slideWidth));

      currentSlide = index;
      isFirstLoad = false; // Change loaded indicator
    };

    // Resize handler function
    this.resize = function() {
      $(window).resize(function() {
        if (resizeTimeout) {
          clearTimeout(resizeTimeout);
          resizeTimeout = null;
        }
        resizeTimeout = setTimeout(function() {
          self.setSizes();
          self.setSlide(currentSlide, false);
        }, 250);
      });
    };

    this.destroy = function() {
      $sliderContainer.removeClass(self.settings.loadedClass);
      clearInterval(animateInterval);
    };

    this.play = function() {
      animateInterval = setInterval(function() {
        self.setSlide(currentSlide + self.settings.itemsPerSlide, true);
        self.play();
      }, self.settings.interval);
    };

    this.stop = function() {
      clearInterval(animateInterval);
    };

    // Finally init slider
    this.init();
  };

  $.fn.coreSlider = function(options) {
    if (options === undefined) {
      options = {};
    }
    if (typeof options === 'object') {
      return this.each(function() {
        new $.coreSlider(this, options);
      });
    }
  }

})(jQuery);
