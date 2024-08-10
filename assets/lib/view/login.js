
export default class LoginView
{
    /**
     * @type {String}
     */
    selector = '#login';
    /**
     * @type {null,Element}
     */
    loginButtonElement = null;
    /**
     * @type {Function}
     */
    loginButtonPressCallback;
    /**
     * @type {Function}
     */
    logoutButtonPressCallback;

    constructor() {
        this.loginButtonPressHandler = this.loginButtonPressHandler.bind(this)
    }

    bind() {
        this.loginButtonElement = document.querySelector(this.selector);
        this.loginButtonElement.onclick = this.loginButtonPressHandler;
    }

    hideSteamIcon() {
        this.loginButtonElement.querySelector('i').classList.add('hidden')
    }

    showSteamIcon() {
        this.loginButtonElement.querySelector('i').classList.remove('hidden')
    }

    changeTextToLogout() {
        this.loginButtonElement.childNodes[2].nodeValue = "Logout\n"
    }

    changeTextToLogin() {
        this.loginButtonElement.childNodes[2].nodeValue = "Login\n"
    }

    loginButtonPressHandler() {
        this.loginButtonPressCallback();
    }

    onLoginButtonPress(callback) {
        this.loginButtonPressCallback = callback;
    }
    onLogoutButtonPress(callback) {
        this.logoutButtonPressCallback = callback;
    }
}
