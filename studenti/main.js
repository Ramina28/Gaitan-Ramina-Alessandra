function initializeazaButonSus() {
    const btn = document.getElementById("btnTop");

    if (!btn) {
        return;
    }

    function scrollFunction() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            btn.style.display = "block";
        } else {
            btn.style.display = "none";
        }
    }

    window.onscroll = scrollFunction;

    btn.addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}


function initializeazaSlideriManuali() {
    document.querySelectorAll('.slider').forEach(slider => {
        const slides = slider.querySelectorAll('.slide-container img');
        const prevBtn = slider.querySelector('.prev');
        const nextBtn = slider.querySelector('.next');
        let currentIndex = 0;

        function showSlide(index) {
            slides.forEach((img, i) => {
                img.style.display = (i === index) ? 'block' : 'none';
            });
        }

        showSlide(currentIndex);

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
            showSlide(currentIndex);
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        });
    });
}

function initializeazaSliderAutomat() {
    let index = 0;
    const slides = document.querySelectorAll(".slide");

    function showSlides() {
        slides.forEach(slide => slide.style.display = "none");
        index++;
        if (index > slides.length) index = 1;
        slides[index - 1].style.display = "block";
        setTimeout(showSlides, 5000);
    }

    if (slides.length > 0) {
        showSlides();
    }
}

/* ================= FAQ ================= */

function initializeazaFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    if (!faqItems.length) return;

    faqItems.forEach(item => {
        const questionBtn = item.querySelector('.faq-question');

        questionBtn.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');

            // închidem alte întrebări deschise
            document.querySelectorAll('.faq-item.active').forEach(openItem => {
                openItem.classList.remove('active');
            });

            // dacă aceasta nu era deschisă, o deschidem
            if (!isOpen) {
                item.classList.add('active');
            }
        });
    });
}

/* ======================================= */

document.addEventListener('DOMContentLoaded', function() {
    initializeazaButonSus();
    initializeazaSlideriManuali();
    initializeazaSliderAutomat();
    initializeazaFAQ(); // <-- important pentru întrebările frecvente
});