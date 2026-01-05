import Block from './Block'
import SlideManager from '../util/SlideManager'
import { gsap } from 'gsap'

export default class Slider extends Block {
  init() {
    this.currentIndex = 0
    this.sliding = false
  }

  onEnterCompleted() {
    this.createSlider()
    this.initSlide()
  }

  bindMethods() {
    this.prevSlide = this.prevSlide.bind(this)
    this.nextSlide = this.nextSlide.bind(this)
  }

  getElems() {
    this.$wrapper = this.el.querySelector('.b-slider__wrapper')
    this.$pagerLeft = this.el.querySelector('.b-slider__pagers .pager--prev')
    this.$pagerRight = this.el.querySelector('.b-slider__pagers .pager--next')

    this.$imageContainers = this.el.querySelectorAll('.b-slider__image')
    this.$images = this.el.querySelectorAll('.b-slider__image .image')

    this.$items = this.el.querySelectorAll('.b-slider__item')

    this.$titles = this.el.querySelectorAll('.b-slider__item-title h2')
    this.$texts = this.el.querySelectorAll('.b-slider__item-text p')
    this.$buttons = this.el.querySelectorAll('.b-slider__item-button .button')

    this.slides = []

    for (let i = 0; i < this.$items.length; i++) {
      this.slides.push({
        container: this.$items[i],
        title: this.$titles[i],
        text: this.$texts[i],
        button: this.$buttons[i],
        imageContainer: this.$imageContainers[i],
        image: this.$images[i],
      })
    }
  }

  events() {
    this.$pagerLeft && this.$pagerLeft.addEventListener('click', this.prevSlide)
    this.$pagerRight && this.$pagerRight.addEventListener('click', this.nextSlide)
  }

  createSlider() {
    this.slider = new SlideManager({
      el: this.$wrapper,
      auto: true,
      length: this.slides.length,
      loop: true,
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

  getSlideElements(index) {
    return [this.slides[index].title, this.slides[index].text, this.slides[index].button]
  }

  initSlide() {
    this.slides[this.currentIndex].container.classList.add('is-active')
    this.slides[this.currentIndex].imageContainer.classList.add('is-active')

    for (let i = 0; i < this.slides.length; i++) {
      if (i === this.currentIndex) continue

      gsap.set(this.slides[i].imageContainer, { xPercent: 101 })
      gsap.set(this.slides[i].image, { xPercent: -101, scale: 1.1 })
      gsap.set(this.getSlideElements(i), { y: 10, opacity: 0, autoAlpha: 0 })
    }
  }

  onSlideChange() {
    return new Promise((resolve) => {
      this.sliding = true
      const oldSlide = this.slides[this.oldIndex]
      const newSlide = this.slides[this.currentIndex]

      gsap.set(newSlide.imageContainer, { xPercent: 101 * this.direction })
      gsap.set(newSlide.image, {
        xPercent: -101 * this.direction,
        scale: 1.1
      })

      if (oldSlide) {
        oldSlide.container.classList.remove('is-active')
        oldSlide.imageContainer.classList.remove('is-active')
      }

      newSlide.container.classList.add('is-active')
      newSlide.imageContainer.classList.add('is-active')

      const tl = gsap.timeline({
        onComplete: () => {
          this.sliding = false
          resolve()
        }
      })

      tl.to(newSlide.imageContainer, {
        xPercent: 0,
        ease: 'power2.out',
        duration: 1,
        delay: 0.2
      })
        .to(newSlide.image, {
          xPercent: 0,
          scale: 1,
          ease: 'power2.out',
          duration: 1,
          onComplete: () => {
            if (oldSlide) {
              gsap.set(oldSlide.imageContainer, { xPercent: 101 * -this.direction })
              gsap.set(oldSlide.image, {
                xPercent: -101 * -this.direction,
                scale: 1.1
              })
            }
          }
        }, 0.2)
        .to(this.getSlideElements(this.oldIndex), {
          y: 10,
          opacity: 0,
          autoAlpha: 0,
          ease: 'power2.in',
          duration: 0.4,
          stagger: 0.1
        }, 0)
        .to(this.getSlideElements(this.currentIndex), {
          y: 0,
          opacity: 1,
          autoAlpha: 1,
          ease: 'power2.out',
          duration: 0.8,
          stagger: 0.1
        }, 0.5)
    })
  }

  prevSlide() {
    this.slider.prev()
  }

  nextSlide() {
    this.slider.next()
  }
}
