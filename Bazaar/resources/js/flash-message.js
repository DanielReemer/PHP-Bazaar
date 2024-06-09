function addFlashMessageFunction() {
    document.addEventListener('DOMContentLoaded', function() {
        let flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.remove();
            }, 5000);
        }
    });
}

addFlashMessageFunction();