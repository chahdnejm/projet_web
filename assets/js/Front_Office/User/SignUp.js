function showStep(step) {
    const steps = document.querySelectorAll('.form-step');
    steps.forEach((el, index) => {
        if (index === step - 1) {
            el.classList.add('form-step-active');
        } else {
            el.classList.remove('form-step-active');
        }
    });
}
function selectGender(gender) {
    // Get both labels
    const maleLabel = document.getElementById('male-label');
    const femaleLabel = document.getElementById('female-label');

    // Reset classes
    maleLabel.classList.remove('active');
    femaleLabel.classList.remove('active');

    // Add 'active' class to the selected gender
    if (gender === 'male') {
        maleLabel.classList.add('active');
    } else if (gender === 'female') {
        femaleLabel.classList.add('active');
    }
}