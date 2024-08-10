
class ModalWindow
{
  /**
   * @type {Element}
   */
  element;
  closeButtonSelector = '.modal-close';
  constructor(element) {
    this.element = element;
    this.closeButtons = element.querySelectorAll(this.closeButtonSelector);
    this.closeButtons.forEach((button) => {
      button.onclick = () => { this.toggleHideShow(); };
    });
  }
  toggleHideShow() {
    this.element.classList.toggle('hidden');
  }
  hideAfterDelay(delay)
  {
    if (typeof delay === 'undefined') {
      delay = 2000;
    }
    setTimeout(() => {
      this.toggleHideShow();
    }, delay);
  }
}

class PleaseWaitModal extends ModalWindow
{
  successElement;
  refreshingElement;
  failureElement;
  textElement;
  /**
   * @param element {Element}
   */
  constructor(element) {
    super(element);
    this.successElement = element.querySelector('.success');
    this.refreshingElement = element.querySelector('.refreshing');
    this.failureElement = element.querySelector('.failure');
    this.textElement = element.querySelector('.text');
  }

  hideAllElements()
  {
    this.textElement.classList.add('hidden');
    this.refreshingElement.classList.add('hidden');
    this.failureElement.classList.add('hidden');
    this.successElement.classList.add('hidden');
  }

  toSuccess()
  {
    this.hideAllElements();
    this.successElement.classList.remove('hidden');
  }

  toFailure()
  {
    this.hideAllElements();
    this.failureElement.classList.remove('hidden');
  }
}

class ModalSelectors
{
  serverStartModalSelector    = '#serverStartModal';
  pleaseWaitModalSelector     = '#pleaseWaitModal';
  serverRestartModalSelector  = '#serverRestartModal';
  serverStopModalSelector     = '#serverStopModal';
}

export default class ModalController
{
  selectors = new ModalSelectors();
  bind() {
    this.serverStartModal   = new ModalWindow(document.querySelector(this.selectors.serverStartModalSelector));
    this.pleaseWaitModal    = new PleaseWaitModal(document.querySelector(this.selectors.pleaseWaitModalSelector));
    this.serverRestartModal = new ModalWindow(document.querySelector(this.selectors.serverRestartModalSelector));
    this.serverStopModal    = new ModalWindow(document.querySelector(this.selectors.serverStopModalSelector));

    /**
     * @type {NodeListOf<Element>[]}
     */
    const tempTriggers = [
      document.querySelector("#serverActions > button.modal1-toggle"),
      document.querySelector("#serverActions > button.modal2-toggle"),
      document.querySelector("#serverActions > button.modal3-toggle"),
      document.querySelector("#serverActions > button.modal4-toggle")
    ];
    const tempTargets = [
      this.serverStartModal,
      this.pleaseWaitModal,
      this.serverRestartModal,
      this.serverStopModal
    ];

    tempTriggers.forEach((elements, index) => {
      tempTriggers[index].onclick = () => {
        tempTargets[index].toggleHideShow();
      }
    });
  }
}