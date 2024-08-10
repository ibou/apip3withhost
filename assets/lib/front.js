import NavController from './nav.js';
import ModalController from './modal.js';
import LoginController from './login.js';
import Router from './router.js';
import Logger from './logger.js';

export default class FrontController
{
    debug;
    router = new Router();
    controllers;
    /**
     * @type Logger logger
     */
    logger;
    view;

    /**
     * @param debug {boolean}
     */
    constructor(debug)
    {
        this.debug = debug;
        this.logger = new Logger(debug);

        const modalController = new ModalController();

        this.controllers = {
            modalController: modalController,
            loginController: new LoginController(this.router, modalController, this.logger),
            navController: new NavController(),
        };
    }

    init()
    {
        const eventLoad = new Promise(function (resolve) {
            window.addEventListener('load', () => {
                resolve()
            });
        });

        const eventBind = new Promise((resolve) => {
            eventLoad.then(() => {
                this.bind();
                resolve();
            });
        });

        let name = this.router.getControllerName();
        this.logger.debug({ controllerName: name })

        if (!name) {
            this.logger.debug("Failed to resolve controller name.")
            return false;
        }

        eventBind.then(() => {
            let controller = this.controllers[name] || new class { handle() {} };
            controller.handle();
        });
    }

    bind()
    {
        for(let name in this.controllers) {
            if (this.hasFunction(this.controllers[name], 'bind')) {
                this.controllers[name].bind();
            }
        }
    }

    hasFunction(object, funcName)
    {
        return typeof object[funcName] === 'function';
    }
}