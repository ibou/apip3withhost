
export default class NavController
{
  toggleAside;
  aside;
  mobileToggleAside;
  mobileAside;
  main;
  table;
  constructor(toggleAside, aside, main, table, mobileToggleAside, mobileAside) {
    this.mobileToggleAside = mobileToggleAside;
    this.mobileAside = mobileAside;
    this.aside = aside;
    this.main = main;
    this.table = table;
    this.toggleAside = toggleAside;
  }
  init() {
    this.toggleAside.onclick = () => {
      this.toggleAside.classList.toggle("!-right-9");
      const chevron = this.toggleAside.getElementsByTagName('i')[0]
      chevron.classList.toggle('bi-chevron-left')
      chevron.classList.toggle('bi-chevron-right')

      this.aside.classList.toggle("-translate-x-full");
      this.main.classList.toggle("lg:ml-[300px]");
      this.table.classList.toggle("lg:max-w-[calc(100vw-385px)]");
    };
    this.mobileToggleAside.onclick = () => {
      this.mobileAside.classList.toggle("-translate-y-full");
      document.body.classList.toggle("overflow-hidden");
    };
  }
}