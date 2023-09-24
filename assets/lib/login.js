
class AuthViaSteamRequest
{
    url = window.location.origin + '/api/auth-via-steam';
    body = {};
    method = 'POST';

    constructor(query) {
        this.body = Object.fromEntries(new URLSearchParams(query));
    }

    async request()
    {
        try {
            const response = await fetch(this.url, {
                method: this.method,
                mode: "cors",
                cache: "no-cache",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(this.body)
            });
            return await response.json();
        } catch (error) {
            console.error('Error: ', error)
        }
    }
}

export default class LoginController
{
    /**
     * @type {Router}
     */
    router;
    /**
     * @type {ModalController}
     */
    modals;
    /**
     * @type {String}
     */
    selector = '#login';
    /**
     * @type {null,Element}
     */
    loginButtonElement = null;

    doHandle = false;
    processedPostBind = false;

    constructor(router, modals) {
        this.router = router;
        this.modals = modals;
    }

    bind()
    {
        this.loginButtonElement = document.querySelector(this.selector);
        this.loginButtonElement.onclick = () => {
            const params = new URLSearchParams({
                'openid.ns': 'http://specs.openid.net/auth/2.0',
                'openid.mode': 'checkid_setup',
                'openid.return_to': window.location.origin + '/auth-via-steam',
                'openid.realm': window.location.origin,
                'openid.identity': 'http://specs.openid.net/auth/2.0/identifier_select',
                'openid.claimed_id': 'http://specs.openid.net/auth/2.0/identifier_select',
            });

            document.location.href = 'https://steamcommunity.com/openid/login?' + params.toString();
        };
    }

    async postBind()
    {
        if (!this.doHandle) {
            this.processedPostBind = true;
            return false;
        }

        // this.router.cleanupAddress();
        // this.modals.pleaseWaitModal.toggleHideShow();

        const request = new AuthViaSteamRequest(this.router.query);
        const response = await request.request();

        console.log({
            response: response
        });

        this.processedPostBind = true;
    }

    handle()
    {
        if (!this.router.hasQuery()) {
            return false;
        }

        this.doHandle = true;
        if (this.processedPostBind) {
            this.postBind();
        }
    }
}
