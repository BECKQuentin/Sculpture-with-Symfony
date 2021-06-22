$(function(){
    
    function onClickBtnLike(e) {
        e.preventDefault();

        const url = this.href;
        const spanCount = this.querySelector('span.js-likes');
        const icon = this.querySelector('i');  
        const label = this.querySelector('span.js-label')      
               
        //afficher loader
        icon.classList.replace('fa-thumbs-up', 'fa-spinner'); 

        axios.get(url).then(function(response) {

            //desafficher loader            
            icon.classList.replace('fa-spinner', 'fa-thumbs-up');                      

            spanCount.textContent = response.data.likes;
            if(icon.classList.contains('fas')) {   
                icon.classList.replace('fas', 'far');
                label.textContent = 'J\'aime'
            } else {
                label.textContent = 'Je n\'aime plus'
                icon.classList.replace('far', 'fas');
            }

        }).catch(function(error) {
            if(error.response.status === 403) {
                //desafficher loader            
                icon.classList.replace('fa-spinner', 'fa-thumbs-up');
                window.alert('Connectez-vous pour liker');                 

            } else {
                window.alert("Une erreur s'est produite, réesasyez plus tard");
            }      
        })
    }


    document.querySelectorAll('a.js-like').forEach(function(link){
        link.addEventListener('click', onClickBtnLike);
    })
    
    
    
  


})//JQuery