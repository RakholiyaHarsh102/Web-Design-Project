function validateForm() {
    const form = document.getElementById('bookingForm');
    const fields = ['trainNumber', 'passengerName', 'gender', 'fromCity', 'toCity', 'class', 'journeyDate'];
    let isValid = true;

    fields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value) {
            isValid = false;
            alert(`${element.previousElementSibling.innerText} is required.`);
        }
    });

    return isValid;
}

function bookTicket(event) {
    if (!validateForm()) {
        event.preventDefault();
    } else {
        alert('Ticket successfully booked!');
    }
}

function displayDateTime() {
    const footer = document.querySelector('footer');
    const now = new Date();
    footer.textContent = `Current Date and Time: ${now.toLocaleString()}`;
}

window.onload = displayDateTime;