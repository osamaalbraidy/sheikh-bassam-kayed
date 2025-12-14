/**
 * Custom JavaScript for Sheikh Bassam Kayed Theme
 *
 * @package Sheikh_Bassam_Kayed
 */

// Mobile Menu - Vanilla JS (Primary - Works without jQuery)
(function() {
    'use strict';
    
    function initMobileMenu() {
        var menuToggle = document.querySelector('.menu-toggle');
        var mainNav = document.querySelector('.main-navigation');
        var menuOverlay = document.querySelector('.mobile-menu-overlay');
        var menuClose = document.querySelector('.menu-close');
        var body = document.body;
        
        if (!menuToggle || !mainNav) {
            return; // Elements not found
        }
        
        function openMenu() {
            if (menuToggle) menuToggle.classList.add('active');
            if (mainNav) mainNav.classList.add('active');
            if (menuOverlay) menuOverlay.classList.add('active');
            if (body) body.classList.add('menu-open');
        }
        
        function closeMenu() {
            if (menuToggle) menuToggle.classList.remove('active');
            if (mainNav) mainNav.classList.remove('active');
            if (menuOverlay) menuOverlay.classList.remove('active');
            if (body) body.classList.remove('menu-open');
        }
        
        // Menu toggle button - Use capture to ensure it fires
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (mainNav.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        }, true);
        
        // Close button
        if (menuClose) {
            menuClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMenu();
            });
        }
        
        // Overlay click
        if (menuOverlay) {
            menuOverlay.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenu();
            });
        }
        
        // Mobile dropdown toggle
        var menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children > a');
        menuItemsWithChildren.forEach(function(item) {
            item.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    var parent = this.parentElement;
                    parent.classList.toggle('active');
                }
            });
        });
        
        // Close menu when clicking outside (on mobile)
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 && mainNav.classList.contains('active')) {
                if (!mainNav.contains(e.target) && !menuToggle.contains(e.target)) {
                    closeMenu();
                }
            }
        });
    }
    
    // Run immediately if DOM is ready, otherwise wait
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileMenu);
    } else {
        initMobileMenu();
    }
})();

// jQuery-dependent features
(function($) {
    'use strict';
    
    if (typeof $ === 'undefined') {
        return; // jQuery not available
    }
    
    $(document).ready(function() {
        
        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
            }
        });
        
        // WhatsApp button animation
        $('.whatsapp-float, .whatsapp-button').on('mouseenter', function() {
            $(this).addClass('hover');
        }).on('mouseleave', function() {
            $(this).removeClass('hover');
        });
        
        // Video embed handling
        $('.video-embed-container').each(function() {
            var $container = $(this);
            var videoUrl = $container.data('video-url');
            
            if (videoUrl) {
                // Check if it's YouTube
                if (videoUrl.indexOf('youtube.com') > -1 || videoUrl.indexOf('youtu.be') > -1) {
                    var videoId = extractYouTubeId(videoUrl);
                    if (videoId) {
                        var embedUrl = 'https://www.youtube.com/embed/' + videoId;
                        $container.html('<iframe src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>');
                    }
                }
                // Check if it's Vimeo
                else if (videoUrl.indexOf('vimeo.com') > -1) {
                    var vimeoId = extractVimeoId(videoUrl);
                    if (vimeoId) {
                        var embedUrl = 'https://player.vimeo.com/video/' + vimeoId;
                        $container.html('<iframe src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>');
                    }
                }
            }
        });
        
        // Gallery lightbox (simple implementation)
        $('.gallery-item img').on('click', function() {
            var imgSrc = $(this).attr('src');
            var imgAlt = $(this).attr('alt') || '';
            
            // Create lightbox
            var lightbox = $('<div class="gallery-lightbox"><div class="lightbox-content"><img src="' + imgSrc + '" alt="' + imgAlt + '"><button class="lightbox-close">&times;</button></div></div>');
            $('body').append(lightbox);
            lightbox.fadeIn(300);
            
            // Close lightbox
            lightbox.on('click', function(e) {
                if ($(e.target).hasClass('gallery-lightbox') || $(e.target).hasClass('lightbox-close')) {
                    lightbox.fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });
        });
        
    });
    
    // Extract YouTube video ID
    function extractYouTubeId(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        var match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }
    
    // Extract Vimeo video ID
    function extractVimeoId(url) {
        var regExp = /(?:vimeo)\.com.*(?:videos|video|channels|)\/([\d]+)/i;
        var match = url.match(regExp);
        return match ? match[1] : null;
    }
    
})(jQuery);

