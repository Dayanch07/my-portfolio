document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contact-form'); // Fixed ID

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);

        fetch('save_message.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', 'Your message has been sent.', 'success');
                    form.reset();
                } else {
                    Swal.fire('Error!', data.error || 'Something went wrong.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'There was an issue sending your message. Please try again later.', 'error');
            });
    });
});
