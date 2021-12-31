function showMessage(message) {
    let ajaxResponse = document.querySelector(".ajax_response");
    ajaxResponse.innerHTML = ajaxResponse.innerHTML + message
    let currentMessages = ajaxResponse.getElementsByTagName('div');

    setTimeout(function () {
        ajaxResponse.removeChild(currentMessages[0]);
    }, 3000)

}

function showModal(modalId) {
    const modal = document.querySelector("#" + modalId);
    modal.style.display = 'flex';

    modal.querySelector(".close").addEventListener('click', function (){
        modal.style.display = 'none';
    });
}
