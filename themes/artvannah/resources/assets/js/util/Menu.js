import { gsap } from 'gsap'
import store from './store'

/**
 * Menu class for handling menu open/close events.
 * @class
 */
export default class Menu {

  /**
   * Constructor for Menu class.
   * @constructor
   */
  constructor() {
    this.menuOpen = false
    this.isAnimating = false
    this.lastScroll = 0

    this.bindMethods()
    this.getElems()
    this.addEvents()
    this.initAnimation()

    this.onPageChange(window.location.href)
  }

  /**
   * Binds the class methods.
   * @method
   * @returns {void}
   */
  bindMethods() {
    this.toggle = this.toggle.bind(this)
  }

  /**
   * Gets the elements. To be implemented.
   * @method
   * @returns {void}
   */
  getElems() {
    this.header = document.querySelector('.header')
    this.toggler = document.querySelector('.header__burger')
    this.$container = document.querySelector('.header__container')
    this.$list = document.querySelectorAll('.header__menu-list')
    this.$wrapperInner = document.querySelectorAll('.header__wrapper--inner')

    this.$logo = document.querySelector('.header__logo')
    this.$pathLogo = this.$logo.querySelector('.i-logo__text')

    this.$items = document.querySelectorAll('.header__menu-item')
    this.links = []

    this.$items.forEach(item => {
      this.links.push({
        label: item.querySelector('.header__menu-link__label'),
        tag: item.querySelector('.header__menu-link__tag'),
        line: item.querySelector('.header__menu-item__line')
      })
    })
  }

  /**
   * Adds the event listeners.
   * @method
   * @returns {void}
   */
  addEvents() {
    this.toggler && this.toggler.addEventListener('click', this.toggle)
  }

  initAnimation() {
    gsap.set([this.$list, this.$wrapperInner], { opacity: 0 })

    gsap.set(this.$wrapperInner, { y: 10 })

    this.links.forEach(link => {
      gsap.set(link.line, { width: 0 })
      gsap.set(link.label, { yPercent: 100 })
    })
  }

  /**
   * Toggles the menu open/close state.
   * @method
   * @returns {void}
   */
  toggle() {
    if (this.isAnimating) return

    if (this.menuOpen) this.close()
    else this.open()
  }

  /**
   * Opens the menu.
   * @method
   * @returns {Promise} A promise that resolves when the menu is opened.
   */
  open() {
    return new Promise((resolve) => {
      this.menuOpen = true

      this.$pathLogo.classList.add('i-logo__text--white')
      this.toggler.classList.add('header__burger--white')
      this.toggler.classList.add('active')
      this.$container.classList.add('active')

      store.smoothScroll.stop()

      const tl = gsap.timeline({ onComplete: resolve })

      tl
        .to(this.$list, {
          opacity: 1,
          duration: 0.7,
        })
        .to(this.$wrapperInner, {
          y: 0,
          opacity: 1,
          duration: 0.7,
          ease: 'sine.out'
        })
        .to(this.links.map(link => link.label), {
          yPercent: 0,
          duration: 0.7,
          ease: 'power2.out',
          stagger: 0.1
        }, 0.5)
        .to(this.links.map(link => link.line), {
          width: '100%',
          duration: 0.7,
          ease: 'power2.out',
          stagger: 0.1
        }, 0.5)
    })
  }

  /**
   * Closes the menu.
   * @method
   * @returns {Promise} A promise that resolves when the menu is closed.
   */
  close() {
    return new Promise((resolve) => {
      this.menuOpen = false

      this.$pathLogo.classList.remove('i-logo__text--white')
      this.toggler.classList.remove('header__burger--white')
      this.toggler.classList.remove('active')
      this.$container.classList.remove('active')

      store.smoothScroll.start()

      const tl = gsap.timeline({ onComplete: resolve })

      tl.to([this.$list, this.$wrapperInner], {
        opacity: 0,

        onComplete: () => {
          gsap.set(this.$wrapperInner, { y: 10 })
          gsap.set(this.links.map(link => link.label), { yPercent: 100 })
          gsap.set(this.links.map(link => link.line), { width: 0 })
        }
      })
    })
  }

  /**
   * Handles the resize event. To be implemented.
   * @method
   * @returns {void}
   */
  resize() { }

  /**
   * Handles the scroll event. To be implemented.
   * @method
   * @returns {void}
   */
  scroll() {
    const currentScroll = window.scrollY
    const viewportHeight = window.innerHeight
    const threshold = 5

    if (!this.ticking) {
      window.requestAnimationFrame(() => {
        if (currentScroll > viewportHeight) {
          if (currentScroll > this.lastScroll + threshold) {
            this.$pathLogo.classList.add('i-logo__text--black')
            this.toggler.classList.add('header__burger--black')
            this.header.classList.add('header--hidden')
          } else if (currentScroll < this.lastScroll - threshold) this.header.classList.remove('header-- 
        } else {
          this.header.classList.remove('header--hidden')
          this.$pathLogo.classList.remove('i-logo__text--black')
          this.toggler.classList.remove('header__burger--black')
        }

        this.lastScroll = currentScroll
        this.ticking = false
      })

      this.ticking = true
    }
  }

  /**
   * Handles the page change event.
   * @method
   * @param {string} loc - The new location.
   * @returns {void}
   */
  // eslint-disable-next-line no-unused-vars
  onPageChange(loc) { }
}
