// Estado dos carrosséis
const carouselStates = {
    hero: { currentIndex: 0, totalSlides: 0 },
    services: { currentIndex: 0, totalSlides: 0 },
    pricing: { currentIndex: 0, totalSlides: 0 }
};

// Inicializar carrosséis ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    initCarousel('hero');
    initCarousel('services');
    initPricingCarousel();
    initForm();
});

// Inicializar carrossel genérico
function initCarousel(type) {
    const track = document.getElementById(`${type}Track`);
    const slides = track.querySelectorAll(`.carousel-slide, .service-card`);
    
    carouselStates[type].totalSlides = slides.length;
    
    // Criar dots se necessário
    if (type === 'hero') {
        createDots(type);
    }
    
    // Mostrar primeiro slide
    updateCarousel(type);
}

// Criar indicadores de dots
function createDots(type) {
    const dotsContainer = document.getElementById(`${type}Dots`);
    const totalSlides = carouselStates[type].totalSlides;
    
    dotsContainer.innerHTML = '';
    
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('div');
        dot.className = 'dot';
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(i, type));
        dotsContainer.appendChild(dot);
    }
}

// Mover carrossel
function moveCarousel(direction, type) {
    const state = carouselStates[type];
    state.currentIndex += direction;
    
    // Loop circular
    if (state.currentIndex < 0) {
        state.currentIndex = state.totalSlides - 1;
    } else if (state.currentIndex >= state.totalSlides) {
        state.currentIndex = 0;
    }
    
    updateCarousel(type);
}

// Ir para slide específico
function goToSlide(index, type) {
    carouselStates[type].currentIndex = index;
    updateCarousel(type);
}

// Atualizar visualização do carrossel
function updateCarousel(type) {
    const track = document.getElementById(`${type}Track`);
    const slides = track.querySelectorAll(`.carousel-slide, .service-card`);
    const currentIndex = carouselStates[type].currentIndex;
    
    // Remover classe active de todos os slides
    slides.forEach(slide => slide.classList.remove('active'));
    
    // Adicionar classe active ao slide atual
    slides[currentIndex].classList.add('active');
    
    // Atualizar dots
    const dotsContainer = document.getElementById(`${type}Dots`);
    if (dotsContainer) {
        const dots = dotsContainer.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }
}

// Inicializar carrossel de preços (scroll horizontal)
function initPricingCarousel() {
    const track = document.getElementById('pricingTrack');
    const cards = track.querySelectorAll('.pricing-card');
    
    carouselStates.pricing.totalSlides = cards.length;
    
    // Criar dots para preços
    createPricingDots();
    
    // Adicionar evento de scroll para atualizar dots
    track.addEventListener('scroll', updatePricingDots);
}

// Criar dots para carrossel de preços
function createPricingDots() {
    const dotsContainer = document.getElementById('pricingDots');
    const totalSlides = carouselStates.pricing.totalSlides;
    
    dotsContainer.innerHTML = '';
    
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('div');
        dot.className = 'dot';
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => scrollToPricingCard(i));
        dotsContainer.appendChild(dot);
    }
}

// Scroll para card de preço específico
function scrollToPricingCard(index) {
    const track = document.getElementById('pricingTrack');
    const cards = track.querySelectorAll('.pricing-card');
    const card = cards[index];
    
    if (card) {
        const scrollLeft = card.offsetLeft - track.offsetLeft - 20;
        track.scrollTo({
            left: scrollLeft,
            behavior: 'smooth'
        });
    }
}

// Atualizar dots do carrossel de preços baseado no scroll
function updatePricingDots() {
    const track = document.getElementById('pricingTrack');
    const cards = track.querySelectorAll('.pricing-card');
    const dotsContainer = document.getElementById('pricingDots');
    const dots = dotsContainer.querySelectorAll('.dot');
    
    let closestIndex = 0;
    let minDistance = Infinity;
    
    cards.forEach((card, index) => {
        const distance = Math.abs(card.offsetLeft - track.scrollLeft);
        if (distance < minDistance) {
            minDistance = distance;
            closestIndex = index;
        }
    });
    
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === closestIndex);
    });
}

// Navegação do carrossel de preços com botões
function moveCarousel(direction, type) {
    if (type === 'pricing') {
        const track = document.getElementById('pricingTrack');
        const cardWidth = track.querySelector('.pricing-card').offsetWidth + 30; // largura + gap
        const newScrollLeft = track.scrollLeft + (direction * cardWidth);
        
        track.scrollTo({
            left: newScrollLeft,
            behavior: 'smooth'
        });
    } else {
        const state = carouselStates[type];
        state.currentIndex += direction;
        
        // Loop circular
        if (state.currentIndex < 0) {
            state.currentIndex = state.totalSlides - 1;
        } else if (state.currentIndex >= state.totalSlides) {
            state.currentIndex = 0;
        }
        
        updateCarousel(type);
    }
}

// Inicializar formulário
function initForm() {
    const form = document.getElementById('registrationForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Coletar dados do formulário
        const formData = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            interest: document.getElementById('interest').value,
            message: document.getElementById('message').value
        };
        
        // Simular envio
        console.log('Dados do formulário:', formData);
        
        // Mostrar mensagem de sucesso
        alert('Cadastro realizado com sucesso! Entraremos em contato em breve.');
        
        // Limpar formulário
        form.reset();
    });
}

// Auto-play para o carrossel hero (opcional)
let autoPlayInterval;

function startAutoPlay(type, interval = 5000) {
    autoPlayInterval = setInterval(() => {
        moveCarousel(1, type);
    }, interval);
}

function stopAutoPlay() {
    clearInterval(autoPlayInterval);
}

// Iniciar auto-play para o carrossel hero
// startAutoPlay('hero', 5000);

// Parar auto-play quando o usuário interagir
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('carousel-btn') || e.target.classList.contains('dot')) {
        stopAutoPlay();
    }
});

// Adicionar suporte para navegação por teclado
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        moveCarousel(-1, 'hero');
    } else if (e.key === 'ArrowRight') {
        moveCarousel(1, 'hero');
    }
});

// Adicionar efeito de parallax nas imagens ao scroll
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.carousel-slide img');
    
    parallaxElements.forEach(element => {
        const speed = 0.5;
        element.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

// Animação de entrada para os cards de preço
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observar todos os cards de preço
document.querySelectorAll('.pricing-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(50px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});
