
export default class LoginController
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
                'openid.return_to': window.location.origin + '/api/auth-via-steam',
                'openid.realm': window.location.origin,
                'openid.identity': 'http://specs.openid.net/auth/2.0/identifier_select',
                'openid.claimed_id': 'http://specs.openid.net/auth/2.0/identifier_select',
            });

            document.location.href = 'https://steamcommunity.com/openid/login?' + params.toString();
        };
    }
}
