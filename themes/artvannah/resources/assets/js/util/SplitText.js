import SplitType from 'split-type'

/**
 * Class representing a SplitText utility.
 */
export default class SplitText {

  /**
   * Create a SplitText instance.
   * @param {Object} params - The parameters for the SplitText instance.
   * @param {HTMLElement} params.el - The element to split.
   * @param {Object} params.options - The options for splitting the text.
   * @param {boolean} [params.options.absolute=false] - Whether to use absolute positioning.
   * @param {string} [params.options.tagName='div'] - The tag name to use for the split elements.
   * @param {string} [params.options.lineClass='line'] - The class name to use
   * for the line split elements.
   * @param {string} [params.options.wordClass='word'] - The class name to use
   * for the word split elements.
   * @param {string} [params.options.charClass='char'] - The class name to use
   * for the character split elements.
   * @param {string} [params.options.types='lines, words, chars'] - The types of
   * elements to split the text into.
   * @param {string} [params.options.split=''] - The character to split the text by
   * (e.g. ' ' to split by spaces).
   */
  constructor({ el, options }) {
    this.el = el
    this.html = el.innerHTML
    this.options = options

    this.lines = []
    this.words = []
    this.chars = []

    this.options = {
      absolute: false,
      tagName: 'div',
      lineClass: 'line',
      wordClass: 'word',
      charClass: 'char',
      types: 'lines, words, chars',
      split: '',
      ...options
    }

    this.init()
    this.getElems()
  }

  /**
   * Initialize the SplitText instance by creating the split elements.
   * @method
   * @returns {void}
   */
  init() {
    SplitType.create(this.el, this.options)
  }

  /**
   * Get the split elements (lines, words, chars) and store them in the instance.
   * @method
   * @returns {void}
   */
  getElems() {
    this.lines = this.el.querySelectorAll(`.${this.options.lineClass}`)
    this.words = this.el.querySelectorAll(`.${this.options.wordClass}`)
    this.chars = this.el.querySelectorAll(`.${this.options.charClass}`)
  }
}
