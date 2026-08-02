/**
 * Foodieland Theme Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Swiper for hero slider
    if (document.querySelector('.hero-slider')) {
        new Swiper('.hero-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true,
            },
        });
    }
    
    // Initialize Swiper for testimonials
    if (document.querySelector('.testimonials-slider')) {
        new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }
    
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
    
    // Search overlay toggle
    const searchToggle = document.querySelector('.search-toggle');
    const searchOverlay = document.querySelector('.search-overlay');
    const searchClose = document.querySelector('.search-close');
    
    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', function() {
            searchOverlay.classList.add('active');
            setTimeout(() => {
                document.querySelector('.search-field')?.focus();
            }, 300);
        });
        
        if (searchClose) {
            searchClose.addEventListener('click', function() {
                searchOverlay.classList.remove('active');
            });
        }
        
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    }
    
    // Sticky header
    const header = document.querySelector('.site-header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                    });
                }
            }
        });
    });
    
    // Add to cart AJAX
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart')) {
            e.preventDefault();
            const productId = e.target.dataset.productId;
            
            fetch(foodieland_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'quick_view_product',
                    product_id: productId,
                    nonce: foodieland_ajax.nonce,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Product added to cart!');
                }
            });
        }
    });
    
    // Newsletter form submission
    window.handleNewsletterSubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        const email = form.querySelector('input[type="email"]').value;
        const messageEl = form.querySelector('.newsletter-message') || form.nextElementSibling;
        
        fetch(foodieland_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'subscribe_newsletter',
                email: email,
                nonce: foodieland_ajax.nonce,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.data.message);
                form.reset();
            } else {
                showToast(data.data.message || 'Something went wrong', 'error');
            }
        })
        .catch(error => {
            showToast('Something went wrong', 'error');
        });
    };
    
    // Recipe favorite toggle
    document.querySelectorAll('.recipe-favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const recipeId = this.dataset.recipeId;
            
            fetch(foodieland_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'toggle_recipe_favorite',
                    recipe_id: recipeId,
                    nonce: foodieland_ajax.nonce,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');
                    if (data.data.action === 'added') {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                }
            });
        });
    });
    
    // Lazy loading images
    if ('loading' in HTMLImageElement.prototype) {
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('loading');
                    observer.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Countdown timer for events
    document.querySelectorAll('.event-countdown').forEach(countdown => {
        const endDate = new Date(countdown.dataset.endDate).getTime();
        
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = endDate - now;
            
            if (distance < 0) {
                clearInterval(timer);
                countdown.innerHTML = 'Event Started!';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            countdown.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }, 1000);
    });
    
});

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Alpine.js data functions
document.addEventListener('alpine:init', () => {
    Alpine.data('headerNav', () => ({
        searchOpen: false,
        mobileMenuOpen: false,
    }));
    
    Alpine.data('newsletterForm', () => ({
        email: '',
        submitting: false,
        async submit() {
            this.submitting = true;
            // Handle submission
            this.submitting = false;
        }
    }));
});
