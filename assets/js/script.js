//hamburger
const headerMenu = document.querySelector('.header__menu'),
       navigation = document.querySelector('.navigation');
headerMenu.addEventListener('click', (e)=> {
    navigation.classList.toggle('active')
})       
//acardion
const blockInformation = document.querySelectorAll('.information__block'),
    informationItem = document.querySelectorAll('.information__item');

function hiddenInformation() {
    blockInformation.forEach(item => {
        item.classList.remove('active')
    })
}
hiddenInformation();
function openInformation(i) {
    blockInformation[i].classList.toggle('active');
}
informationItem.forEach((item, index)=> {
    item.addEventListener('click', ()=> {
        openInformation(index);
    })
})
//sliders
new Splide('#slider1', {
    perPage: 5,
    rewind : true,
    padding: '5rem',
    pagination: false,
    focus  : 'center',
    breakpoints: {
		1750: {
			perPage: 4,
		},
        1400: {
			perPage: 5,
            padding: '3rem',
		},
        993: {
			perPage: 4,
            padding: '3rem',
            arrows: false,
		},
        800: {
			perPage: 3,
            padding: '5rem',
		},
        660: {
			perPage: 3,
            padding: '2rem',
		},
        550: {
			perPage: 2,   
            padding: '5rem',         
		},
        450: {
			perPage: 2,   
            padding: '1rem',         
		},
        370: {
			perPage: 1,   
            padding: '5rem',         
		},
    }
    
}).mount(); 
new Splide('#slider2', {
    perPage: 5,
    rewind : true,
    padding: '5rem',
    pagination: false,
    focus  : 'center',
    breakpoints: {
		1750: {
			perPage: 4,
		},
        1400: {
			perPage: 5,
            padding: '3rem',
		},
        993: {
			perPage: 4,
            padding: '3rem',
            arrows: false,
		},
        800: {
			perPage: 3,
            padding: '5rem',
		},
        660: {
			perPage: 3,
            padding: '2rem',
		},
        550: {
			perPage: 2,   
            padding: '5rem',         
		},
        450: {
			perPage: 2,   
            padding: '1rem',         
		},
        370: {
			perPage: 1,   
            padding: '5rem',         
		},
    }
    
}).mount(); 
new Splide('#slider3', {
    perPage: 4,
    rewind : true,
    pagination: false,
    focus: 'center',
    breakpoints: {
		1750: {
			perPage: 4,
		},
        1400: {
			perPage: 3,
            padding: '1rem',
		},
        1200: {
            arrows: false
		},
        993: {
			perPage: 2,
            padding: '10rem',
		},
        800: {
			perPage: 2,
            padding: '2rem',
		},
        800: {
            padding: '1rem',
		},
        660: {
			perPage: 1,
            padding: '10rem',
		},
        550: { 
            padding: '5rem',         
		},
        450: {
            padding: '3rem',         
		},
        370: {
			perPage: 1,   
            padding: '1rem',         
		},
    }
    
}).mount(); 

