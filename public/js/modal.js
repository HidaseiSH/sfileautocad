all_modals = ['main-modal','modal-confirm']
all_modals.forEach((modal)=>{
   document.querySelector('.'+modal);
    // modalSelected.classList.remove('fadeIn');
    // modalSelected.classList.add('fadeOut');
    // modalSelected.style.display = 'none';
})
const modalClose = (modal) => {
    let modalToClose = document.querySelector('.'+modal);
    modalToClose.classList.remove('fadeIn');
    modalToClose.classList.add('fadeOut');
    setTimeout(() => {
        modalToClose.style.display = 'none';
    }, 500);
}

const openModal = (modal) => {
    let modalToOpen = document.querySelector('.'+modal);
    modalToOpen.classList.remove('fadeOut');
    modalToOpen.classList.add('fadeIn');
    modalToOpen.style.display = 'flex';
}