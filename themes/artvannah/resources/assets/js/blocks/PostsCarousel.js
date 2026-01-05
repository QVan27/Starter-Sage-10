import Block from './Block'
import SlideManager from '../util/SlideManager'
import { gsap } from 'gsap'

export default class PostsCarousel extends Block {
  onEnterCompleted() {
    this.createSlider()
  }

  bindMethods() {
    this.prevSlide = this.prevSlide.bind(this)
    this.nextSlide = this.nextSlide.bind(this)
  }

  getElems() {
    this.container = this.el.querySelector('.b-posts-carousel__container')
    this.$wrapper = this.container.querySelector('.b-posts-carousel__wrapper')
    this.$slides = this.container.querySelectorAll('.c-post-card')

    this.$pagerLeft = this.el.querySelector('.pager--prev')
    this.$pagerRight = this.el.querySelector('.pager--next')

    this.space = parseInt(getComputedStyle(this.$wrapper).gap)
    this.slideWidth = this.$slides[0].offsetWidth + this.space
  }

  events() {
    this.$pagerLeft?.addEventListener('click', this.prevSlide)
    this.$pagerRight?.addEventListener('click', this.nextSlide)
  }

  createSlider() {
    this.slider = new SlideManager({
      el: this.$wrapper,
      length: this.$slides.length,
      pager: {
        prevEl: this.$pagerLeft,
        nextEl: this.$pagerRight,
        getVisibleSlides: () => Math.floor(this.container.offsetWidth / this.slideWidth)
      },
      callback: (event) => {
        this.currentIndex = event.new
        this.onSlideChange().then(() => this.slider.done())
      }
    })
  }

  onSlideChange() {
    return new Promise((resolve) => {
      gsap.to(this.$wrapper, {
        x: -this.currentIndex * this.slideWidth,
        duration: 1.2,
        ease: 'expo.out',
        onStart: resolve
      })
    })
  }

  prevSlide() {
    this.slider.prev()
  }

  nextSlide() {
    this.slider.next()
  }

  resize() {
    this.slideWidth = this.$slides[0].offsetWidth + this.space

    gsap.set(this.$wrapper, {
      x: -this.currentIndex * this.slideWidth
    })

    this.slider.updatePagerState()
  }
}
