const contentImageTab =() =>{
    const tabButtons = document.querySelectorAll('.control-btn');
    const images = document.querySelectorAll('.content-image-tab__images-container .image')
    tabButtons.forEach((button)=>{
        button.addEventListener('click', e=>{
            e.preventDefault();

            const id = button.dataset.image;
            tabButtons.forEach(tb=>{
                if(tb === button){
                    tb.classList.add('active');
                }else{
                    tb.classList.remove('active');
                }
            })

            images.forEach(image=>{
                if(image.id === id){
                    image.classList.add('active');
                }else{
                    image.classList.remove('active');
                }
            })
        })
    })
};

export default contentImageTab;