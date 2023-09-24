import NavController from './nav.js';
import ModalController from './modal.js';
import LoginController from './login.js';
import Router from './router.js';

export default class FrontController
{
    debug;
    router = new Router();
    controllers;

    constructor(debug)
    {
        this.debug = debug;

        const modalController = new ModalController();
        this.controllers = {
            modalController: modalController,
            loginController: new LoginController(this.router, modalController),
            navController: new NavController(),
        };
    }

    init()
    {
        window.addEventListener('load', () => {
            this.bind();
        });

        for(let name in this.controllers) {
            if (this.hasFunction(this.controllers[name], 'init')) {
                this.controllers[name].init();
            }
        }

        let name = this.router.getControllerName();

        if (this.debug) {
            console.debug({
                controllerName: name
            });
        }

        if (!name) {
            return false;
        }

        let controller = this.controllers[name] || new class { handle() {} };
        controller.handle();
    }

    bind()
    {
        for(let name in this.controllers) {
            if (this.hasFunction(this.controllers[name], 'bind')) {
                this.controllers[name].bind();
            }
        }

        for(let name in this.controllers) {
            if (this.hasFunction(this.controllers[name], 'postBind')) {
                this.controllers[name].postBind();
            }
        }
    }

    hasFunction(object, funcName)
    {
        return typeof object[funcName] === 'function';
    }
}