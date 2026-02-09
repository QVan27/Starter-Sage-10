import Block from './Block'
import { TextAnimator } from '../util/TextAnimator'

export default class PostCard extends Block {
  getElems() {
    this.$tag = this.el.querySelector('.c-post-card__category')
  }

  events() {
    const animator = new TextAnimator(this.$tag)

    this.el.addEventListener('mouseenter', () => {
      animator.animate()
    })
  }
}
