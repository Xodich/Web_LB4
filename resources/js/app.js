import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const infoModal = document.getElementById('infoModal');
    const detailButtons = document.querySelectorAll('.item-detail-btn');
    let currentIndex = -1;

    if (infoModal) {
        const modalInstance = new bootstrap.Modal(infoModal);

        // Функция обновления контента модалки
        const updateModalContent = (button) => {
            currentIndex = parseInt(button.getAttribute('data-index'));
            
            const name = button.getAttribute('data-name');
            const bio = button.getAttribute('data-bio');
            const img = button.getAttribute('data-img');

            infoModal.querySelector('#modalName').textContent = name;
            infoModal.querySelector('#modalBio').innerHTML = bio.replace(/\n/g, '<br>');
            const modalImg = infoModal.querySelector('#modalImg');
            
            if (img && img.includes('storage')) {
                modalImg.src = img;
                modalImg.style.display = 'inline-block';
            } else {
                modalImg.style.display = 'none';
            }

            const date = button.getAttribute('data-date');
            infoModal.querySelector('#modalDate').textContent = date ? date : 'Не указана';
        };

        infoModal.addEventListener('show.bs.modal', (event) => {
            updateModalContent(event.relatedTarget);
            const date = button.getAttribute('data-date');
                const modalDate = infoModal.querySelector('#modalDate');
            if (modalDate) {
                modalDate.textContent = date ? date : 'Не указана';
            }
        });

        document.addEventListener('keydown', (event) => {
            if (infoModal.classList.contains('show')) {
                let nextIndex = -1;

                if (event.key === 'ArrowRight') {
                    nextIndex = (currentIndex + 1) % detailButtons.length;
                } else if (event.key === 'ArrowLeft') {
                    nextIndex = (currentIndex - 1 + detailButtons.length) % detailButtons.length;
                }

                if (nextIndex !== -1) {
                    const nextButton = document.querySelector(`.item-detail-btn[data-index="${nextIndex}"]`);
                    if (nextButton) {
                        updateModalContent(nextButton);
                    }
                }
            }
        });
    }
});