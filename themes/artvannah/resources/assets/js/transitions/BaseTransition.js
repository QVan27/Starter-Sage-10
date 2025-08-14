import { Transition } from '@unseenco/taxi'
import store from '../util/store'

export default class BaseTransition extends Transition {
  onLeave({ done, from }) {
    this.from = from
    store.smoothScroll && store.smoothScroll.stop()

    this.getElems()

    store.transitionComplete = false

    this.showLoader().then(() => {
      store.transitionComplete = true

      if (store.transitionComplete) this.transitionComplete()
      else window.addEventListener('transitionComplete', this.transitionComplete.bind(this), { once: true })

      done()
    })
  }

  onEnter({ done, to }) {
    this.to = to
    this.done = done

    this.getElems()
  }

  resetScroll() {
    window.scrollTo(0, 0)

    if (store.scrollEngine === 'lenis') {
      store.smoothScroll.scrollTo(0, { immediate: true })
      store.smoothScroll.start()
      store.smoothScroll.targetScroll = 0
    }
  }

  transitionComplete() {
    this.hideLoader(this.from, this.to).then(() => this.done())
  }

  hideLoader() { }

  showLoader() { }

  getElems() { }
}
