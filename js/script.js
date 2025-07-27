const nav = document.querySelector(".navbar");

function toggleMenu(){
    nav.classList.toggle("show");
}

function validAge()
{
    const ageInput=document.getElementById("age").value;
    if(!ageInput || ageInput<16)
    {
        alert("you'r age is not valid for playing this game");
        return false;
    }
    return true;
}

document.querySelectorAll('.profile-img-option').forEach(img => {
    img.addEventListener('click', function() {
       document.querySelectorAll('.profile-img-option').forEach(el => el.classList.remove('selected'));
       this.classList.add('selected');
       document.getElementById('selected-pic').value = this.getAttribute('data-pic');
    });
 });


