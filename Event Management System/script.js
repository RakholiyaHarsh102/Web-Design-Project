function validateForm() {
    const eventName = document.getElementById('eventName').value;
    const eventDate = document.getElementById('eventDate').value;
    const eventDescription = document.getElementById('eventDescription').value;
    const participants = document.getElementById('participants').value;

    if (!eventName || !eventDate || !eventDescription || !participants) {
        alert('All fields are required.');
        return false;
    }

    return true;
}

function confirmSave(event) {
    if (!validateForm()) {
        event.preventDefault();
    } else {
        const confirmSave = confirm('Are you sure you want to save this event?');
        if (!confirmSave) {
            event.preventDefault();
        }
    }
}