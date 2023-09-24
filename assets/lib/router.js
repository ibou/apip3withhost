
export default class Router
{
    paths;
    constructor(paths)
    {
        this.paths = window.paths;
        this.query = window.location.search;
        window.onpopstate = this.handleLocationChange;
    }

    handleLocationChange()
    {

    }

    hasQuery()
    {
        return this.query !== '';
    }

    cleanupAddress()
    {
        history.replaceState({}, "", window.location.pathname);
    }

    getControllerName()
    {
        const path = window.location.pathname;
        const name = this.paths[path] || false;

        if (!name) {
            return false;
        }

        return name.split('_')[1] + 'Controller';
    }
}