/*
==========================================================================
   FoodGrids - Main JS Controller (Integrated with Laravel)
   This script handles UI interactions like preloader, sticky navbar,
   mobile menu, and active link detection.
==========================================================================
*/

(function () {
    "use strict";

    // 1. ===== Preloader (شاشة التحميل) =====
    // بتخفي شاشة التحميل بمجرد ما المتصفح يخلص تحميل كل العناصر
    window.onload = function () {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            window.setTimeout(function () {
                preloader.style.opacity = '0';
                preloader.style.display = 'none';
            }, 500);
        }
    };

    // 2. ===== Sticky Header & Scroll To Top (تثبيت الهيدر وزر الصعود) =====
    window.onscroll = function () {
        const header_navbar = document.querySelector(".navbar");
        const backToTo = document.querySelector(".scroll-top");

        // تثبيت الهيدر عند النزول لأسفل
        if (header_navbar) {
            const sticky = header_navbar.offsetTop;
            if (window.pageYOffset > sticky) {
                header_navbar.classList.add("sticky");
            } else {
                header_navbar.classList.remove("sticky");
            }
        }

        // إظهار زر العودة للأعلى بعد نزول 50 بكسل
        if (backToTo) {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                backToTo.style.display = "flex";
            } else {
                backToTo.style.display = "none";
            }
        }
    };

    // 3. ===== Mobile Menu Toggle (قائمة الموبايل) =====
    // متوافق مع كلاسات Bootstrap 5 الموجودة في front.blade.php
    let navbarToggler = document.querySelector(".navbar-toggler");
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function () {
            navbarToggler.classList.toggle("active");
        });
    }

    // 4. ===== Laravel Active Link Handler (تحديد الصفحة الحالية) =====
    // الميزة دي بتخلي الرابط (Home, Menu, etc.) يتلون بالذهبي أوتوماتيكياً
    document.addEventListener('DOMContentLoaded', function() {
        // بنجيب المسار الحالي من المتصفح (مثلاً /menu)
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        navLinks.forEach(link => {
            // تنظيف أي كلاس active قديم
            link.classList.remove('active');

            // مقارنة رابط الزرار بالمسار اللي واقفين عليه
            // لو المسار هو "/" بنضيف active لصفحة الهوم
            const linkHref = link.getAttribute('href');
            if (linkHref === currentPath || (currentPath === '/' && linkHref === '/')) {
                link.classList.add('active');
            }
        });
    });

})();
