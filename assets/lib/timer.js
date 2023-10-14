
export default class Timer
{
    timeout;
    counter = 0;
    step = 1000;
    id = null;

    finished = false;

    /**
     * @param timeout Milliseconds
     * @param counter Initial value ( default. 0 )
     * @param step How much to add to the counter with each tick
     */
    constructor(timeout, counter, step)
    {
        if (typeof counter === 'undefined') {
            counter = 0;
        }
        if (typeof step === 'undefined') {
            step = 1000;
        }

        this.timeout = timeout;
        this.counter = counter;
        this.step = step;
    }

    start()
    {
        return new Promise((resolve, reject) =>
        {
            this.id = setInterval(() =>
            {
                if (this.counter >= this.timeout) {
                    this.stop();
                    resolve();
                }
                this.counter += this.step;
            }, this.step);
        });
    }

    stop()
    {
        this.finished = true;
        clearInterval(this.id);
    }

    hasFinished()
    {
        return this.finished;
    }
}