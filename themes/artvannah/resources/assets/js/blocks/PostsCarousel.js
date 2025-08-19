import Block from './Block'
import SlideManager from '../util/SlideManager'
import { gsap } from 'gsap'

export default class PostsCarousel extends Block {
  onEnterCompleted() {
    this.$pagerLeft.classList.add('is-disabled')

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

    this.$pagerLeft = this.el.querySelector('.b-posts-carousel__pagers .pager--prev')
    this.$pagerRight = this.el.querySelector('.b-posts-carousel__pagers .pager--next')
  }

  events() {
    this.$pagerLeft && this.$pagerLeft.addEventListener('click', this.prevSlide)
    this.$pagerRight && this.$pagerRight.addEventListener('click', this.nextSlide)
  }

  createSlider() {
    this.slider = new SlideManager({
      el: this.$wrapper,
      callback: (event) => {
        this.oldIndex = event.previous
        this.currentIndex = event.new
        this.direction = event.direction

        this.onSlideChange()
          .then(() => {
            this.slider.done()
          })
      }
    })
  }

  onSlideChange() {
    return new Promise((resolve) => {
      const slideWidth = this.$slides[0].offsetWidth + 30;
      const newTransformValue = -this.currentIndex * slideWidth;

      gsap.to(this.$wrapper, {
        x: newTransformValue,
        duration: 0.3,
        ease: 'sine.out'
      })

      this.$pagerLeft.classList.toggle('is-disabled', this.currentIndex === 0)
      this.$pagerRight.classList.toggle('is-disabled', this.currentIndex === this.$slides.length - 1)

      resolve()
    })
  }

  prevSlide() {
    this.slider.prev()
  }

  nextSlide() {
    this.slider.next()
  }

  resize() {
    const slideWidth = this.$slides[0].offsetWidth + 30
    const newTransformValue = -this.currentIndex * slideWidth

    gsap.to(this.$wrapper, {
      x: newTransformValue,
      duration: 0
    })
  }
}
