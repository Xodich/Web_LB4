import './bootstrap';
import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const infoModal = document.getElementById('infoModal');
    const detailButtons = document.querySelectorAll('.item-detail-btn');
    let currentIndex = -1;

    if (infoModal) {
        const modalInstance = new bootstrap.Modal(infoModal);

        // ФУНКЦИЯ ЗАПОЛНЕНИЯ МОДАЛКИ
        const updateModal = (btn) => {
            currentIndex = parseInt(btn.getAttribute('data-index'));
            
            // Заполняем текстовые поля
            document.getElementById('modalName').textContent = btn.getAttribute('data-name');
            document.getElementById('modalBio').innerHTML = btn.getAttribute('data-bio').replace(/\n/g, '<br>');
            document.getElementById('modalOwnerDisplay').textContent = "Владелец: " + btn.getAttribute('data-owner');
            
            // ВАЖНО: ЗАПОЛНЯЕМ ДАТУ
            const date = btn.getAttribute('data-date');
            document.getElementById('modalDate').textContent = date ? date : 'Не указана';
            
            // Обработка картинки
            const img = btn.getAttribute('data-img');
            const modalImg = document.getElementById('modalImg');
            if (img && img.includes('storage')) {
                modalImg.src = img;
                modalImg.style.display = 'inline-block';
            } else {
                modalImg.src = '';
                modalImg.style.display = 'none';
            }
        };

        // Открытие по клику на кнопку "ИНФО"
        detailButtons.forEach(btn => {
            btn.addEventListener('click', () => updateModal(btn));
        });

        // ПЕРЕКЛЮЧЕНИЕ ПО СТРЕЛКАМ
        document.addEventListener('keydown', (e) => {
            if (!infoModal.classList.contains('show')) return;

            let nextIndex = -1;
            if (e.key === 'ArrowRight') {
                nextIndex = (currentIndex + 1) % detailButtons.length;
            } else if (e.key === 'ArrowLeft') {
                nextIndex = (currentIndex - 1 + detailButtons.length) % detailButtons.length;
            }

            if (nextIndex !== -1) {
                const nextBtn = document.querySelector(`.item-detail-btn[data-index="${nextIndex}"]`);
                if (nextBtn) updateModal(nextBtn);
            }
        });
    }
});