/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

class LoginController
{
    /**
     * @var Element
     */
    element;
    constructor(element) {
        this.element = element;
    }
    init() {
        this.element.onclick = () => {
            const params = new URLSearchParams({
                'openid.ns': 'http://specs.openid.net/auth/2.0',
                'openid.mode': 'checkid_setup',
                'openid.return_to': window.location.origin + '/steam-auth',
                'openid.realm': window.location.origin,
                'openid.identity': 'http://specs.openid.net/auth/2.0/identifier_select',
                'openid.claimed_id': 'http://specs.openid.net/auth/2.0/identifier_select',
            });
            const url = 'https://steamcommunity.com/openid/login?' + params.toString();
            console.log({
                url: url
            });
        };
    }
}


const loginController = new LoginController(document.querySelector('#login'))
loginController.init();