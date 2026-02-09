import Block from './Block'
import { TextAnimator } from '../util/TextAnimator'

export default class Button extends Block {
  events() {
    const animator = new TextAnimator(this.el)

    this.el.addEventListener('mouseenter', () => {
      animator.animate()
    })
  }
}
