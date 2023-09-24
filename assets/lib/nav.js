
class NavController
{
  selectors;
  elements;
  constructor()
  {
    this.selectors = new NavControllerSelectors();
  }

  bind() {
    this.elements = new NavControllerElements(this.selectors);

    this.elements.toggleMenuButton.onclick = () =>
    {
      this.elements.toggleMenuButton.classList.toggle("!-right-9");
      const chevron = this.elements.toggleMenuButton.getElementsByTagName('i')[0]
      chevron.classList.toggle('bi-chevron-left')
      chevron.classList.toggle('bi-chevron-right')

      this.elements.desktopMenu.classList.toggle("-translate-x-full");
      this.elements.main.classList.toggle("lg:ml-[300px]");
      this.elements.serviceDetails.classList.toggle("lg:max-w-[calc(100vw-385px)]");
    };
    this.elements.mobileToggleButton.onclick = () =>
    {
      this.elements.mobileMenu.classList.toggle("-translate-y-full");
      document.body.classList.toggle("overflow-hidden");
    };
  }
}

class NavControllerElements
{
  constructor(selectors)
  {
    this.toggleMenuButton = document.querySelector(selectors.toggleMenuButton);
    this.desktopMenu = document.querySelector(selectors.desktopMenu);
    this.main = document.querySelector(selectors.main);
    this.serviceDetails = document.querySelector(selectors.serviceDetails);
    this.mobileToggleButton = document.querySelector(selectors.mobileToggleButton);
    this.mobileMenu = document.querySelector(selectors.mobileMenu);
  }
}

class NavControllerSelectors
{
  constructor()
  {
    this.toggleMenuButton = '#toggleMenuButton';
    this.desktopMenu = '#desktopMenu';
    this.main = '#main';
    this.serviceDetails = '#serviceDetails';
    this.mobileToggleButton = '#mobileToggleButton';
    this.mobileMenu = '#mobileMenu';
  }
}

export default NavController;