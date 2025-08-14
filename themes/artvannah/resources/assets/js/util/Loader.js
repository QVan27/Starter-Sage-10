import gsap from 'gsap'
import store from './store'

/**
 * Loader class for handling the loading animation.
 * @class
 */
export default class Loader {
  constructor() {
    this.getElems()

    store.smoothScroll.stop()
  }

  getElems() {
    store.panel = document.querySelector('.panel')
  }

  play() {
    return new Promise((resolve) => {
      const tl = gsap.timeline({
        onComplete: () => {
          store.smoothScroll.start()

          store.menu && !store.detect.isMobile && store.menu.init()

          window.dispatchEvent(new CustomEvent('loaderComplete'))

          store.isFirstLoaded = true

          resolve()
        }
      })

      // eslint-disable-next-line prefer-reflect
      tl
        .to(store.panel, {
          opacity: 0,
          duration: 0.8,
          ease: 'power3.out'
        })
    })
  }
}
