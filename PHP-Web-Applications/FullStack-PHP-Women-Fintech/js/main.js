// totul trebuie sa fie incarcat
document.addEventListener('DOMContentLoaded', function() { 
    const form = document.querySelector('form'); 
    // avem nevoie de un form submit
    if(form) { 
        form.addEventListener('submit', function(e) { 
            const email = document.querySelector('input[name="email"]'); 
            const linkedin = document.querySelector('input[name="linkedin_profile"]'); 
             
            if(email && !validateEmail(email.value)) { 
                e.preventDefault(); 
                alert('Please enter a valid email address'); 
            } 
             
            if(linkedin && linkedin.value && !validateLinkedIn(linkedin.value)) { 
                e.preventDefault(); 
                alert('Please enter a valid LinkedIn URL'); 
            } 
        }); 
    } 

    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }
}); 

function validateEmail(email) { 
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email); 
} 
 
function validateLinkedIn(url) { 
    return url.includes('linkedin.com/'); 
}

//    salveaza preferinta dark/light
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    
    const isDark = document.body.classList.contains('dark-mode');
    
    localStorage.setItem('darkMode', isDark);
}