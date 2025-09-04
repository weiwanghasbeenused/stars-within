export default class Carousel {
    constructor(container){
        this.container = container;
        this.slides = [];
        this.idx = -1;
        this.init();
    }
    init(){
        this.getElements();
        this.addListeners();
        this.updateIndex(0);
    }
    getElements(){
        this.slides = this.container.querySelectorAll('.slide');
        this.spring = this.container.querySelector('.slides-spring');
        this.dots = this.container.querySelectorAll('.dot');
        this.prev_button = this.container.querySelector('.prev-button');
        this.next_button = this.container.querySelector('.next-button');
    }
    addListeners(){
        for(let i = 0; i < this.dots.length; i++) {
            this.dots[i].addEventListener('click', ()=>{
                this.updateIndex(i);
            })
        }
        this.prev_button.addEventListener('click', ()=>{
            if(this.idx === 0) return;
            this.updateIndex(this.idx-1);
        })
        this.next_button.addEventListener('click', ()=>{
            if(this.idx === this.slides.length - 1) return;
            this.updateIndex(this.idx+1);
        })
    }
    updateIndex(newIdx){
        if(newIdx === this.idx) return;
        this.dots[this.idx]?.classList.remove('active');
        this.idx = newIdx;
        this.dots[this.idx].classList.add('active');
        this.jump(this.idx);
    }
    jump(idx){
        console.log(this.spring);
        this.spring.style.setProperty('--slide-idx', idx);
    }
}