const modal1 = document.querySelector("#modal1");
const modal_toggles1 = document.querySelectorAll(".modal1-toggle");
const modal2 = document.querySelector("#modal2");
const modal_toggles2 = document.querySelectorAll(".modal2-toggle");
const modal3 = document.querySelector("#modal3");
const modal_toggles3 = document.querySelectorAll(".modal3-toggle");
modal_toggles1.forEach((item) => {
  item.addEventListener("click", () => {
    modal1.classList.toggle("hidden");
  });
});
modal_toggles2.forEach((item) => {
  item.addEventListener("click", () => {
    modal2.classList.toggle("hidden");
  });
});
modal_toggles3.forEach((item) => {
  item.addEventListener("click", () => {
    modal3.classList.toggle("hidden");
  });
});

export default class ModalController
{
  constructor() {
  }
  init() {

  }
}