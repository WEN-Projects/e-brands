const popupModal = () => {

//Need to add data-id on the trigger-modal and same id on the modal
    let body = document.querySelector("body");
    let modals = document.querySelectorAll(".modal");
    let triggers = document.querySelectorAll(".trigger-modal");
    let closeButtons = document.querySelectorAll(".close-button");

    const toggleModal = (modalId) => {
        modals.forEach(modal => {
            if (modal.id === modalId) {
                modal.classList.toggle("show-modal");
                body.classList.toggle("modal-open");
            }
        });
    };

    const windowOnClick = (event) => {
        modals.forEach(modal => {
            if (event.target === modal) {
                toggleModal(modal.id);
            }
        });
    };

    triggers.forEach(trigger => {
        trigger.addEventListener("click", (e) => {
            e.preventDefault();
            toggleModal(trigger.dataset.id);
        });
    });

    closeButtons.forEach(closeButton => {
        closeButton.addEventListener("click", () => {
            let modalId = closeButton.parentElement.parentElement.id;
            toggleModal(modalId);
        });
    });

    document.addEventListener("click", windowOnClick);

    document.addEventListener("keydown", (event) => {
        if (event.key === 'Escape') {
            modals.forEach(modal => {
                if (modal.classList.contains("show-modal")) {
                    toggleModal(modal.id);
                }
            });
        }
    });
};

export default popupModal;