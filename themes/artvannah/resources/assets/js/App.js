import 'whatwg-fetch'
import 'intersection-observer'

import LazyLoad from 'vanilla-lazyload'
import { throttle, debounce } from 'throttle-debounce'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

// Utils
import Loader from './util/Loader'
import Menu from './util/Menu'
import Anchor from './util/Anchor'
import store from './util/store'
import Observer from './util/Observer'
import Lenis from 'lenis'

// Renderer
import Page from './routes/Page'

// Transitions
import * as Taxi from '@unseenco/taxi'
import Fade from './transitions/Fade'

// Cursor
import MouseFollower from 'mouse-follower'

export default class App {
  constructor() {
    this.resize = this.resize.bind(this)
    this.scroll = this.scroll.bind(this)
    this.update = this.update.bind(this)

    this.raf = null

    this.resizeDebounced = debounce(100, this.resize)
    this.resizeThrottled = throttle(150, this.resize)

    if (!store.scrollEngine) {
      this.scrollDebounced = debounce(100, this.scroll)
      this.scrollThrottled = throttle(50, this.scroll)
    }

    store.w = {
      w: window.innerWidth,
      h: window.innerHeight,
      pR: Math.min(window.devicePixelRatio, 2)
    }

    this.start()
  }

  start() {
    if (store.scrollEngine === 'lenis') this.initLenis()
    else this.initObserver()

    store.loader = new Loader()
    this.menu = new Menu()
    this.anchor = new Anchor()
    this.lazyLoad = new LazyLoad()

    this.initTaxi().then(() => {
      this.events()
      this.update()

      if ('scrollRestoration' in history) history.scrollRestoration = 'manual'

      window.scrollTo(0, 0)

      this.checkAnchor()
      // this.initCursor()
    })
  }

  initObserver() {
    store.observer = new Observer()
  }

  initLenis() {
    gsap.registerPlugin(ScrollTrigger)

    store.smoothScroll = new Lenis({ lerp: 0.08 })

    store.smoothScroll.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
      store.smoothScroll.raf(time * 1000)
    })

    gsap.ticker.lagSmoothing(0);

    this.initObserver()
  }

  initTaxi() {
    return new Promise((resolve) => {
      store.router = new Taxi.Core({
        renderers: { default: Page },
        transitions: { default: Fade },
        links: 'a:not([target]):not([href^=\\#]):not([href^="mailto:"]):not([href^="tel:"]):not([data-taxi-ignore]):not([href*="wp-admin"]):not(.ab-item):not([href*="wp-login.php?action=logout"])'
      })

      this.setCurrentRenderer().then(resolve)
    })
  }

  initCursor() {
    MouseFollower.registerGSAP(gsap)

    store.cursor = new MouseFollower({
      skewing: 0,
      skewingText: 0,
      skewingIcon: 0,
      skewingMedia: 0,
      iconSvgSrc: document.getElementById('mf-sprite').innerHTML,
      stateDetection: {
        '-hidden': 'button,.e-button'
      }
    })
  }

  setCurrentRenderer() {
    return new Promise((resolve) => {
      this.currentRenderer = store.router.currentCacheEntry.renderer
      resolve(this.currentRenderer)
    })
  }

  resize() {
    store.w = {
      w: window.innerWidth,
      h: window.innerHeight,
      pR: Math.min(window.devicePixelRatio, 2)
    }

    this.currentRenderer.resize()
    this.menu && this.menu.resize()
  }

  scroll(e) {
    store.scrollEngine === 'lenis' && (store.smoothScroll.direction = this.oldScroll <= e ? 1 : -1)
    this.currentRenderer.scroll(e)
    this.menu && this.menu.scroll()
    this.oldScroll = e
  }

  update() {
    this.currentRenderer.loop()
    requestAnimationFrame(this.update)
  }

  events() {
    if (store.detect.isMobile) window.addEventListener('orientationchange', this.resize)
    else {
      window.addEventListener('resize', this.resizeThrottled)
      window.addEventListener('resize', this.resizeDebounced)
    }

    if (store.scrollEngine === 'lenis') {
      store.smoothScroll.on('scroll', ({ scroll }) => {
        this.scroll(scroll)
      })
    } else {
      window.addEventListener('scroll', this.scrollThrottled)
      window.addEventListener('scroll', this.scrollDebounced)
    }

    store.router.on('NAVIGATE_IN', ({ to }) => {
      this.currentRenderer = to.renderer
      document.title = to.page.title
      this.lazyLoad.update()
      this.menu.onPageChange(store.router.currentLocation.href)
    })

    store.router.on('NAVIGATE_END', ({ to }) => {
      if (typeof ga !== 'undefined') {
        ga('set', 'location', to.page.URL);
        ga('set', 'page', store.router.targetLocation.pathname)
        ga('set', 'title', to.page.title)
        ga('send', 'pageview')
      }

      this.menu.onPageChange(location.href)

      this.checkAnchor(location)
    })
  }

  checkAnchor(location = null) {
    const bodyClassSubmit = Array.from(document.body.classList).find((elt) => elt.includes('formsubmit'))
    let anchor = null

    if (location && location.anchor) anchor = location.anchor
    else if (bodyClassSubmit) {
      const validate = document.querySelector('#gform_confirmation_message_' + bodyClassSubmit.split('-')[1])
      const error = document.querySelector('#gform_wrapper_' + bodyClassSubmit.split('-')[1])

      if (validate) anchor = 'gform_confirmation_message_' + bodyClassSubmit.split('-')[1]
      else if (error) anchor = 'gform_wrapper_' + bodyClassSubmit.split('-')[1]
    } else {
      const idx = window.location.href.indexOf('#')

      if (idx !== -1) anchor = window.location.href.substring(idx + 1)
    }

    if (anchor) {
      const el = document.querySelector('#' + anchor)

      if (el) {
        if (store.scrollEngine === 'lenis') {
          store.smoothScroll.start()
          store.smoothScroll.scrollTo(el, { offset: -100 })
        } else {
          const elRect = el.getBoundingClientRect()

          window.scrollTo(0, elRect.top)
        }
      }
    }
  }
}
