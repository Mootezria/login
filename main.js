const inputs = document.querySelectorAll(".input");

function addcl() {
    let parent = this.parentNode.parentNode;
    parent.classList.add("focus");
}

function remcl() {
    let parent = this.parentNode.parentNode;
    if(this.value == "") {
        parent.classList.remove("focus");
    }
}

inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);
});

document.getElementById('signUpButton').addEventListener('click', function(event) {
    event.preventDefault();  // Empêche le formulaire de soumettre
    window.location.href = 'signup.php';  // Redirige vers signup.php
});
