import NavController from './nav.js';
import ModalController from './modal.js';
import LoginController from './login.js';

export default class FrontController
{
    controllers = {
        loginController: new LoginController(document.querySelector('#login')),
        navController: new NavController(
            document.querySelector("#toggle-aside"),
            document.querySelector("#desktop-menu"),
            document.querySelector("#main"),
            document.querySelector("#table-container"),
            document.querySelector("#mobile-btn"),
            document.querySelector("#mobile-menu")
        ),
        modalController: new ModalController(),
    };

    init()
    {
        for(name in this.controllers) {
            this.controllers[name].init();
        }
    }
}