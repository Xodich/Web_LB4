import '../scss/main.scss';
import * as bootstrap from 'bootstrap';

// Popover
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
[...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

// Переключение по стрелкам
const infoModal = document.getElementById('infoModal');
const detailButtons = document.querySelectorAll('.item-card .btn-primary');
let currentButtonIndex = -1;

if (infoModal) {
    const modalInstance = new bootstrap.Modal(infoModal);
    infoModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;

        currentButtonIndex = Array.from(detailButtons).findIndex(btn => btn === button);

        const modalTitle = button.getAttribute('data-modal-title');
        const modalBodyRaw = button.getAttribute('data-modal-body');
        const modalImgSrc = button.getAttribute('data-modal-img');
        const modalAbilitiesRaw = button.getAttribute('data-abilities');

        const modalBodyHtml = modalBodyRaw.replace(/\\n/g, '<br><br>');

        infoModal.querySelector('.modal-title').textContent = modalTitle;
        infoModal.querySelector('#modal-content-text').innerHTML = modalBodyHtml;
        infoModal.querySelector('#modal-content-img-container').innerHTML = `
            <img src="${modalImgSrc}" alt="${modalTitle}" class="img-fluid rounded-3" style="max-height: 200px; object-fit: cover;">
        `;

        const abilitiesContainer = infoModal.querySelector('#modal-abilities-container');
        abilitiesContainer.innerHTML = '';
        if (modalAbilitiesRaw) {
            let abilitiesHtml = '<h5 class="mb-3">Способности</h5>';
            modalAbilitiesRaw.split(';').forEach(ability => {
                const parts = ability.split('|');
                if (parts.length === 3) {
                    const [iconPath, title, description] = parts;
                    abilitiesHtml += `
                        <div class="ability-item mb-3 d-flex align-items-start">
                            <img src="${iconPath}" alt="${title}" class="ability-icon me-3">
                            <div>
                                <h6 class="ability-title mb-1">${title}</h6>
                                <p class="ability-description mb-0">${description}</p>
                            </div>
                        </div>
                    `;
                }
            });
            abilitiesContainer.innerHTML = abilitiesHtml;
        }
    });

    // Переключение по клавиатуре
    document.addEventListener('keydown', (event) => {
        if (infoModal.classList.contains('show')) {
            let targetButtonIndex = -1;

            if (event.key === 'ArrowRight') {
                targetButtonIndex = (currentButtonIndex + 1) % detailButtons.length;
            } else if (event.key === 'ArrowLeft') {
                targetButtonIndex = (currentButtonIndex - 1 + detailButtons.length) % detailButtons.length;
            }

            if (targetButtonIndex !== -1) {
                event.preventDefault();
                modalInstance.hide();

                const hiddenHandler = () => {
                    detailButtons[targetButtonIndex].click();
                    infoModal.removeEventListener('hidden.bs.modal', hiddenHandler);
                };

                infoModal.addEventListener('hidden.bs.modal', hiddenHandler);
            }
        }
    });
}

// Toast
const toastTrigger = document.getElementById('liveToastBtn');
const toastLiveExample = document.getElementById('liveToast');

if (toastTrigger && toastLiveExample) {
    const toastBootstrap = new bootstrap.Toast(toastLiveExample);

    toastTrigger.addEventListener('click', () => {
        toastBootstrap.show();
    });
}