const checkboxes = document.querySelectorAll('input.question-checkbox');

Array.from(checkboxes).forEach(checkbox => {
    if (!checkbox.checked) {
        checkbox.addEventListener('change',() => checkToggle(checkbox));
    }
});

function checkToggle(checkbox) {
    const id = checkbox.dataset.questionId;

    fetch('/account/check/' + id, {method: 'POST'}).then((response) => {
        if(response.status === 200) {
            checkbox.disabled = true;
        }
    });
}