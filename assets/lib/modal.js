
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
    this.pleaseWaitModal    = new ModalWindow(document.querySelector(this.selectors.pleaseWaitModalSelector));
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